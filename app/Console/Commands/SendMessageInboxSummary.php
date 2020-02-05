<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Mail\MessageInboxSummary;
use Illuminate\Support\Facades\Mail;
use App\Helpers\MultipleEmails;
use App\Helpers\NotificationContent;

class SendMessageInboxSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wedbooker:sendMessageInboxSummary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send message inbox summary to all users who has unread message.';

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
        User::with(['vendorProfile', 'coupleA'])->whereHas('unreadNotifications', function ($q) {
            $q->where('type', 'Musonza\\Chat\\Notifications\\MessageSent');
        })->get()->each(function ($user) {

            $email_notification = (new NotificationContent)->getEmailContent('Send Message Inbox Summary', 'vendor,couple');

            $userEmails = ($user->account == "vendor") ? (new MultipleEmails)->getMultipleEmails($user) : $user->email;
            $title = ($user->vendorProfile) ? $user->vendorProfile->business_name : $user->coupleA->title ;
            
            Mail::to($userEmails)
                ->send(new MessageInboxSummary($title, $email_notification));
        });
    }
}
