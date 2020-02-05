<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Notifications\AccountNotificationSummary;
use App\Helpers\NotificationContent;
use App\Helpers\MultipleEmails;
use Notification;

class SendAfternoonAccountNotificationSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wedbooker:sendAfternoonAccountNotificationSummary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send account notification summary to user at 4pm.';

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
        $afternoon = Carbon::parse('16:00:00');

        User::whereHas('notificationSettings', function ($q) {
            $q->where('meta_value', '<>', 'immediate');
        })->whereHas('unreadNotifications', function ($q) use ($morning, $afternoon) {
            $q->whereNotNull('data')
                ->where('created_at', '>', $morning)->where('created_at', '<=', $afternoon)
                ->where('type', '<>', 'App\\Notifications\\AddVendorReview')
                ->where('type', '<>', 'Musonza\Chat\Notifications\MessageSent');
        })->whereIn('status', [0, 1])->with([
            'notificationSettings' => function ($q) {
                $q->where('meta_key', 'all')->addSelect(['id', 'user_id', 'meta_key', 'meta_value']);
            },
            'unreadNotifications' => function ($q) use ($morning, $afternoon) {
                $q->addSelect(['id', 'type', 'data', 'created_at', 'notifiable_id'])->whereNotNull('data')
                    ->where('created_at', '>', $morning)->where('created_at', '<=', $afternoon)
                    ->where('type', '<>', 'Musonza\Chat\Notifications\MessageSent')
                    ->where('type', '<>', 'App\\Notifications\\AddVendorReview')
                    ->limit(10)->orderBy('created_at', 'DESC');
            }
        ])->chunk(100, function ($users) {
            $users->map(function ($user) {
                $frequency = 'once daily';

                if ($user->notificationSettings && isset($user->notificationSettings[0])) {
                    $frequency = $user->notificationSettings[0]->meta_value;
                }

                $email_notification = (new NotificationContent)->getEmailContent('Send Afternoon Account Notification Summary', 'vendor,couple');
                $emails = ($user->account == "vendor") ? (new MultipleEmails)->getMultipleEmails($user) : $user->email;
                Notification::route('mail', $emails)->notify(new AccountNotificationSummary($user->unreadNotifications, $frequency, $email_notification));
            });
        });
    }
}
