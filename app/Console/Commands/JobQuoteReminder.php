<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Notifications\JobQuoteReminder as JobQuoteNotification;
use App\Helpers\MultipleEmails;
use App\Helpers\NotificationContent;
use App\Models\User;
use App\Models\JobPost;
use App\Models\JobQuote;
use Notification;

class JobQuoteReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wedbooker:jobQuoteReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify couple of the job quote with no response sent after 5 days';

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
        $users = User::whereHas('jobPosts', function($q) {
                $q->whereHas('quotes', function($q) {
                    $q->whereDate('updated_at', Carbon::today()->subDays(5))
                        ->where('status', 1);
                });
            })
            ->with(['jobPosts' => function($q) {
                $q->with(['quotes' => function($q) {
                    $q->whereDate('updated_at', Carbon::today()->subDays(5))
                        ->where('status', 1);
                }]);
            }])
            ->get();
            
        $email_notification = (new NotificationContent)->getEmailContent('Job Quote Reminder', 'couple');
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Job Quote Reminder', 'couple');

        foreach($users as $user) {
            foreach($user->jobPosts as $jobPost) {
                foreach($jobPost->quotes as $jobQuote) {
                    $user->notify(new JobQuoteNotification(
                        [
                            'title' => $email_notification->subject,
                            'body' => $email_notification->body,
                            'btnLink' => sprintf('/dashboard/job-quotes/%s', $jobQuote->id),
                            'btnTxt' => $email_notification->button,
                            'business_name' => $jobQuote->user->vendorProfile->business_name
                        ],
                        $user,
                        $email_notification,
                        $email_notification->type
                    ));

                    foreach($dashboard_notifications as $dashboard_notification) {
                        $user->notify(new JobQuoteNotification(
                            [
                                'title' => $dashboard_notification->subject,
                                'body' => $dashboard_notification->body,
                                'btnLink' => sprintf('/dashboard/job-quotes/%s?', $jobQuote->id),
                                'btnTxt' => $dashboard_notification->button,
                                'business_name' => $jobQuote->user->vendorProfile->business_name
                            ],
                            $user,
                            $dashboard_notification,
                            $dashboard_notification->type
                        ));
                    }
                }
            }

        }
    }
}
