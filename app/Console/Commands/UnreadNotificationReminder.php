<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\GenericNotification;
use App\Mail\UnreadNotification;
use App\Helpers\MultipleEmails;
use Illuminate\Support\Facades\Mail;
use App\Helpers\NotificationContent;

class UnreadNotificationReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wedbooker:unreadNotificationReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email couple or business reminding them they have new notifications';

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
        $users = User::whereStatus(1)->whereIn('account', ['couple', 'vendor'])->get();

        $email_notification = (new NotificationContent)->getEmailContent('Unread Notification', 'vendor,couple');
        foreach ($users as $user) {
            if ($user->unreadNotifications->count()) {
                $userEmails = ($user->account == "vendor") ? (new MultipleEmails)->getMultipleEmails($user) : $user->email;

                Mail::to($userEmails)
                    ->send(new UnreadNotification($user, $email_notification));
            }
        }
    }
}
