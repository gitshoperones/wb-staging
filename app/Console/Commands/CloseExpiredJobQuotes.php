<?php

namespace App\Console\Commands;

use App\Models\JobQuote;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Notifications\GenericNotification;
use App\Helpers\NotificationContent;
use App\Helpers\MultipleEmails;
use Notification;

class CloseExpiredJobQuotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wedbooker:closeExpiredJobQuotes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close all job quotes that already expired.';

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
        $jobQuotes = JobQuote::where('status', 1)->whereDate('duration', '<=', Carbon::today())->get();

        $notification_vendor = (new NotificationContent)->getEmailContent('Job Quote Expired', 'vendor');
        $notification_couple = (new NotificationContent)->getEmailContent('Job Quote Expired', 'couple');
        $dashboard_vendor = (new NotificationContent)->getNotificationContent('Job Quote Expired', 'vendor');
        $dashboard_couple = (new NotificationContent)->getNotificationContent('Job Quote Expired', 'couple');

        foreach ($jobQuotes as $jobQuote) {
            $couple = $jobQuote->jobPost->user;
            
            $notification_vendor_subject = str_replace('[couple_title]', ucwords(strtolower(isset($couple->coupleProfile()->title) ? $couple->coupleProfile()->title : '')), $notification_vendor->subject);
            $notification_vendor_body = str_replace('[couple_title]', ucwords(strtolower(isset($couple->coupleProfile()->title) ? $couple->coupleProfile()->title : '')), $notification_vendor->body);
            $emails = (new MultipleEmails)->getMultipleEmails($jobQuote->user);

            Notification::route('mail', $emails)->notify(new GenericNotification([
                'title' => $notification_vendor_subject,
                'body' => $notification_vendor_body,
                'btnLink' => url(sprintf('/dashboard/job-quotes/%s/edit', $jobQuote->id)),
                'btnTxt' => $notification_vendor->button,
                'jobQuoteId' => $jobQuote->id,
                'notification_type' => $notification_vendor->type
            ]));

            foreach($dashboard_vendor as $dashboard) {
                $dashboard_subject = str_replace('[couple_title]', ucwords(strtolower(isset($couple->coupleProfile()->title) ? $couple->coupleProfile()->title : '')), $dashboard->subject);
                $dashboard_body = str_replace('[couple_title]', ucwords(strtolower(isset($couple->coupleProfile()->title) ? $couple->coupleProfile()->title : '')), $dashboard->body);
                $jobQuote->user->notify(new GenericNotification([
                    'title' => $dashboard_subject,
                    'body' => $dashboard_body,
                    'btnLink' => url(sprintf('/dashboard/job-quotes/%s/edit', $jobQuote->id)),
                    'btnTxt' => $dashboard->button,
                    'jobQuoteId' => $jobQuote->id,
                    'notification_type' => $dashboard->type
                ]));
            }

            $notification_couple_subject = str_replace('[business_name]', ucwords(strtolower(isset($jobQuote->user->vendorProfile->business_name) ? $jobQuote->user->vendorProfile->business_name : '')), $notification_couple->subject);
            $notification_couple_body = str_replace('[business_name]', ucwords(strtolower(isset($jobQuote->user->vendorProfile->business_name) ? $jobQuote->user->vendorProfile->business_name : '')), $notification_couple->body);
            $couple->notify(new GenericNotification([
                'title' => $notification_couple_subject,
                'body' => $notification_couple_body,
                'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $jobQuote->user_id)),
                'btnTxt' => $notification_couple->button,
                'jobQuoteId' => $jobQuote->id,
                'notification_type' => $notification_couple->type
            ]));

            foreach($dashboard_couple as $dashboard) {
                $dashboard_subject = str_replace('[business_name]', ucwords(strtolower(isset($jobQuote->user->vendorProfile->business_name) ? $jobQuote->user->vendorProfile->business_name : '')), $dashboard->subject);
                $dashboard_body = str_replace('[business_name]', ucwords(strtolower(isset($jobQuote->user->vendorProfile->business_name) ? $jobQuote->user->vendorProfile->business_name : '')), $dashboard->body);
                $couple->notify(new GenericNotification([
                    'title' => $dashboard_subject,
                    'body' => $dashboard_body,
                    'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $jobQuote->user_id)),
                    'btnTxt' => $dashboard->button,
                    'jobQuoteId' => $jobQuote->id,
                    'notification_type' => $dashboard->type
                ]));
            }

            $jobQuote->status = 5;
            $jobQuote->save();
        }
    }
}
