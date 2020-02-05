<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Notifications\DraftJobReminder as DraftJobNotification;
use App\Helpers\MultipleEmails;
use App\Helpers\NotificationContent;
use App\Models\User;
use App\Models\JobPost;
use App\Models\JobQuote;
use Notification;
use App\Mail\NewJobPost;
use Illuminate\Support\Facades\Mail;

class DraftJobReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wedbooker:draftJobReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify couples of the drafted job post after 5 days';

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
        $jobPosts = JobPost::where('status', 0)
            ->whereDate('updated_at', Carbon::today()->subDays(2))
            ->get();
            
        $email_notification = (new NotificationContent)->getEmailContent('Draft Job Reminder', 'couple');
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Draft Job Reminder', 'couple');
        $admin_notification = (new NotificationContent)->getEmailContent('Draft Job Reminder', 'admin');

        foreach($jobPosts as $jobPost) {
            $jobPost->user->notify(new DraftJobNotification(
                [
                    'title' => $email_notification->subject,
                    'body' => $email_notification->body,
                    'btnLink' => sprintf('/dashboard/job-posts/%s/edit', $jobPost->id),
                    'btnTxt' => $email_notification->button,
                ],
                $jobPost->user,
                $email_notification,
                $email_notification->type
            ));

            Mail::to(config('mail.from.address'))->send(new NewJobPost($jobPost, $admin_notification));

            foreach($dashboard_notifications as $dashboard_notification) {
                $jobPost->user->notify(new DraftJobNotification(
                    [
                        'title' => $dashboard_notification->subject,
                        'body' => $dashboard_notification->body,
                        'btnLink' => sprintf('/dashboard/job-posts/%s/edit?', $jobPost->id),
                        'btnTxt' => $dashboard_notification->button,
                    ],
                    $jobPost->user,
                    $dashboard_notification,
                    $dashboard_notification->type
                ));
            }
        }
    }
}
