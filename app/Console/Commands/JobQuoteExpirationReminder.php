<?php

namespace App\Console\Commands;

use App\Models\JobQuote;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Notifications\JobQuoteExpirationReminder as JobQuoteExpirationNotification;
use App\Helpers\NotificationContent;
use App\Helpers\MultipleEmails;
use Notification;
class JobQuoteExpirationReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wedbooker:jobQuoteExpirationReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind both couple and vendor for a job quote that is about to expire.';

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
        $jobQuotes = JobQuote::where('status', 1)->whereDate('duration', Carbon::today()->addDays(3))
            ->with([
                'jobPost' => function ($q) {
                    $q->addSelect([
                        'id', 'user_id',
                    ])->with([
                        'user',
                        'userProfile' => function ($q) {
                            $q->addSelect(['id', 'userA_id', 'title', 'profile_avatar']);
                        }
                    ]);
                },
                'user' => function ($q) {
                    $q->addSelect(['id', 'email'])->with([
                        'vendorProfile' => function ($q) {
                            $q->addSelect(['id', 'user_id', 'business_name']);
                        }
                    ]);
                },
            ])->get(['id', 'user_id', 'job_post_id']);

        $notification_vendor = (new NotificationContent)->getEmailContent('Job Quote Expiration Reminder', 'vendor');
        $notification_couple = (new NotificationContent)->getEmailContent('Job Quote Expiration Reminder', 'couple');
        $dashboard_vendor = (new NotificationContent)->getNotificationContent('Job Quote Expiration Reminder', 'vendor');
        $dashboard_couple = (new NotificationContent)->getNotificationContent('Job Quote Expiration Reminder', 'couple');
            
        foreach ($jobQuotes as $jobQuote) {
            $email_subject = str_replace('[business_name]', (isset($jobQuote->user->vendorProfile->business_name) ? $jobQuote->user->vendorProfile->business_name : ''), $notification_couple->subject);
            $jobQuote->jobPost->user->notify(new JobQuoteExpirationNotification([
                'title' => $email_subject,
                'body' => $notification_couple->body,
                'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $jobQuote->user->id)),
                'btnTxt' => $notification_couple->button
            ], $jobQuote->jobPost->user, 'email')); // couple
            
            foreach($dashboard_couple as $dashboard) {
                $dashboard_subject = str_replace('[business_name]', ucwords(strtolower(isset($jobQuote->user->vendorProfile->business_name) ? $jobQuote->user->vendorProfile->business_name : '')), $dashboard->subject);
                $jobQuote->jobPost->user->notify(new JobQuoteExpirationNotification([
                    'title' => $dashboard_subject,
                    'body' => $dashboard->body,
                    'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s&', $jobQuote->user->id)),
                    'btnTxt' => $dashboard->button,
                    'jobQuoteId' => $jobQuote->jobPost->id,
                    'notification_type' => $dashboard->type
                ], $jobQuote->jobPost->user, 'dashboard'));
            }

            $email_subject = str_replace('[couple_title]', ucwords(strtolower(isset($jobQuote->jobPost->userProfile->title) ? $jobQuote->jobPost->userProfile->title : '')), $notification_vendor->subject);
            $emails = (new MultipleEmails)->getMultipleEmails($jobQuote->user);

            Notification::route('mail', $emails)->notify(new JobQuoteExpirationNotification([
                'title' => $email_subject,
                'body' => $notification_vendor->body,
                'btnLink' => url(sprintf('dashboard/job-quotes/%s/edit?extend=true', $jobQuote->id)),
                'btnTxt' => $notification_vendor->button
            ], $jobQuote->user, 'email')); //vendor

            foreach($dashboard_vendor as $dashboard) {
                $dashboard_subject = str_replace('[couple_title]', ucwords(strtolower(isset($jobQuote->jobPost->userProfile->title) ? $jobQuote->jobPost->userProfile->title : '')), $dashboard->subject);
                $jobQuote->user->notify(new JobQuoteExpirationNotification([
                    'title' => $dashboard_subject,
                    'body' => $dashboard->body,
                    'btnLink' => url(sprintf('dashboard/job-quotes/%s/edit?extend=true&', $jobQuote->id)),
                    'btnTxt' => $dashboard->button,
                    'jobQuoteId' => $jobQuote->id,
                    'notification_type' => $dashboard->type
                ], $jobQuote->jobPost->user, 'dashboard'));
            }
        }
    }
}
