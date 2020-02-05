<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Notifications\JobMatchReminder as JobMatchNotification;
use App\Helpers\MultipleEmails;
use App\Helpers\NotificationContent;
use App\Models\User;
use App\Models\JobPost;
use App\Models\JobQuote;
use Notification;

class JobMatchReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wedbooker:jobMatchReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify business of the job matched with no quotes sent after 5 days';

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
        $users = User::whereHas('notifications', function($q) {
                $q->where('type', 'App\Notifications\NewJobPosted')
                    ->whereDate('created_at', Carbon::today()->subDays(5));
            })
            ->with(['notifications' => function($q) {
                $q->where('type', 'App\Notifications\NewJobPosted')
                    ->whereDate('created_at', Carbon::today()->subDays(5));
            }])
            ->get();
            
        $email_notification = (new NotificationContent)->getEmailContent('Job Match Reminder', 'vendor');
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Job Match Reminder', 'vendor');

        foreach($users as $user) {
            
            foreach($user->notifications->pluck('data')->all() as $jobPost) {
                $jobQuote = JobQuote::where('job_post_id', $jobPost['jobPostId'])->get();
                $job = JobPost::where('id', $jobPost['jobPostId'])->first();
                
                if(count($jobQuote) === 0) {
                    $emails = (new MultipleEmails)->getMultipleEmails($user);

                    Notification::route('mail', $emails)->notify(new JobMatchNotification(
                        [
                            'title' => $email_notification->subject,
                            'body' => $email_notification->body,
                            'btnLink' => sprintf('/dashboard/job-posts/%s', $jobPost['jobPostId']),
                            'btnTxt' => $email_notification->button,
                            'couple_title' => $job->user->coupleProfile() !== null ? $job->user->coupleProfile()->title : 'Couple'
                        ],
                        $user,
                        $email_notification,
                        'email'
                    ));

                    foreach($dashboard_notifications as $dashboard_notification) {
                        $user->notify(new JobMatchNotification(
                            [
                                'title' => $dashboard_notification->subject,
                                'body' => $dashboard_notification->body,
                                'btnLink' => sprintf('/dashboard/job-posts/%s?', $jobPost['jobPostId']),
                                'btnTxt' => $dashboard_notification->button,
                                'couple_title' => $job->user->coupleProfile() !== null ? $job->user->coupleProfile()->title : 'Couple'
                            ],
                            $user,
                            $dashboard_notification,
                            'dashboard'
                        ));
                    }
                }
            }
        }
    }
}
