<?php

namespace App\Console\Commands;

use App\Models\JobPost;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Notifications\GenericNotification;
use App\Helpers\NotificationContent;

class JobPostExpirationReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wedbooker:jobPostExpirationReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind couples for job posts that are about to expire due to inactivity in a span of 50 days.';

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
        $jobPosts = JobPost::where('status', 1)
            ->whereDate('updated_at', Carbon::today()->subWeeks(11))
            ->with(['category' => function ($q) {
                $q->addSelect(['id', 'name']);
            }, 'user' => function ($q) {
                $q->addSelect(['id', 'email']);
            }])->get(['id', 'user_id', 'category_id']);

        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Job Post Expiration Reminder', 'couple');

        foreach ($dashboard_notifications as $dashboard_notification) {
            foreach ($jobPosts as $jobPost) {
                $dashboard_notification_body = str_replace('[category_name]', ucwords(strtolower(isset($jobPost->category->name) ? $jobPost->category->name : '')), $dashboard_notification->body);
                $jobPost->user->notify(new GenericNotification([
                    'title' => $dashboard_notification->subject,
                    'body' => $dashboard_notification_body,
                    'btnLink' => url(sprintf('/dashboard/job-posts/extend-expiration/%s', $jobPost->id)),
                    'btnTxt' => $dashboard_notification->button,
                    'jobPostId' => $jobPost->id,
                    'notification_type' => $dashboard_notification->type
                ], $jobPost->user));
            }
        }

        $notification = (new NotificationContent)->getEmailContent('Job Post Expiration Reminder', 'couple');
        foreach ($jobPosts as $jobPost) {
            $notification_body = str_replace('[category_name]', ucwords(strtolower(isset($jobPost->category->name) ? $jobPost->category->name : '')), $notification->body);
            $jobPost->user->notify(new GenericNotification([
                'title' => $notification->subject,
                'body' => $notification_body,
                'btnLink' => url(sprintf('/dashboard/job-posts/extend-expiration/%s', $jobPost->id)),
                'btnTxt' => $notification->button,
                'jobPostId' => $jobPost->id,
                'notification_type' => $notification->type
            ], $jobPost->user));
        }
    }
}
