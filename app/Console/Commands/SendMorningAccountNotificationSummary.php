<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Notifications\AccountNotificationSummary;
use App\Helpers\NotificationContent;
use App\Helpers\MultipleEmails;
use Notification;

class SendMorningAccountNotificationSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wedbooker:sendMorningAccountNotificationSummary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send account notification summary to user at 6am.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $morning = Carbon::parse('06:00:00');
        $afternoon = Carbon::parse('16:00:00')->subDay();

        $users = User::whereHas('notificationSettings', function ($q) {
            $q->where('meta_key', 'all')->where('meta_value', 'twice daily');
        })->whereHas('unreadNotifications', function ($q) use ($morning, $afternoon) {
            $q->where('type', '<>', 'Musonza\\Chat\\Notifications\\MessageSent')
                ->where('type', '<>', 'App\\Notifications\\AddVendorReview')
                ->whereNotNull('data')->where(function ($q) use ($morning, $afternoon) {
                    $q->where('created_at', '<=', $morning)->where('created_at', '>', $afternoon);
                });
        })->whereIn('status', [0, 1])->with([
            'notificationSettings' => function ($q) {
                $q->where('meta_key', 'all')->addSelect(['id', 'user_id', 'meta_key', 'meta_value']);
            },
            'unreadNotifications' => function ($q) use ($morning, $afternoon) {
                $q->addSelect(['id', 'type', 'data', 'created_at', 'notifiable_id'])
                    ->where('type', '<>', 'Musonza\\Chat\\Notifications\\MessageSent')
                    ->where('type', '<>', 'App\\Notifications\\AddVendorReview')
                    ->whereNotNull('data')->where(function ($q) use ($morning, $afternoon) {
                        $q->where('created_at', '<=', $morning)->where('created_at', '>', $afternoon);
                    })->limit(10)->orderBy('created_at', 'DESC');
            }
        ])->chunk(100, function ($users) {
            $users->map(function ($user) {
                $email_notification = (new NotificationContent)->getEmailContent('Send Morning Account Notification Summary', 'vendor,couple');
                $emails = ($user->account == "vendor") ? (new MultipleEmails)->getMultipleEmails($user) : $user->email;
                Notification::route('mail', $emails)->notify(new AccountNotificationSummary($user->unreadNotifications, 'twice daily', $email_notification));
            });
        });
    }
}
