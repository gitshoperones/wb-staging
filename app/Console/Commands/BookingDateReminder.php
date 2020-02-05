<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Search\ConfirmedBooking\ConfirmedBookingSearchManager;
use App\Models\Invoice;
use App\Notifications\GenericNotification;
use App\Helpers\NotificationContent;
use App\Helpers\MultipleEmails;
use Notification;

class BookingDateReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wedbooker:bookingDateReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications reminding them 30 days before the booking date.';

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
        $eagerLoads = [
            'jobQuote' => function ($q) {
                $q->with([
                    'milestones' => function ($q) {
                        $q->where('job_quote_milestones.paid', 0);
                    },
                    'jobPost' => function ($q) {
                        $q->addSelect([
                            'id', 'user_id', 'event_date', 'event_id', 'category_id'
                        ])->with(['locations' => function ($q) {
                            $q->addSelect(['locations.id', 'name']);
                        }, 'event' => function ($q) {
                            $q->addSelect(['events.id', 'name']);
                        }, 'category' => function ($q) {
                            $q->addSelect(['categories.id', 'name']);
                        }, 'userProfile' => function ($q) {
                            $q->addSelect(['id', 'userA_id', 'userB_id', 'title']);
                        }]);
                    },
                    'user' => function ($q) {
                        $q->with(['vendorProfile' => function ($q) {
                            $q->addSelect([
                                'id', 'user_id', 'business_name', 'business_name', 'profile_avatar'
                            ]);
                        }])->addSelect('id');
                    }
                ]);
            },
            'vendor'
        ];

        $invoices = Invoice::whereHas('jobQuote', function ($q) {
            $q->whereHas('jobPost', function ($q) {
                return $q->where('event_date', now()->addDays(30)->format('Y-m-d'));
            });
        })->with($eagerLoads)->get();
        
        $notification_vendor = (new NotificationContent)->getEmailContent('Booking Date Reminder', 'vendor');
        $notification_couple = (new NotificationContent)->getEmailContent('Booking Date Reminder', 'couple');
        $dashboard_vendor = (new NotificationContent)->getNotificationContent('Booking Date Reminder', 'vendor');
        $dashboard_couple = (new NotificationContent)->getNotificationContent('Booking Date Reminder', 'couple');

        foreach ($invoices as $invoice) {
            $couple = $invoice->jobQuote->jobPost->user;
            $vendor = $invoice->vendor;
            $emails = (new MultipleEmails)->getMultipleEmails($vendor->user);
            
            $notification_vendor_subject = str_replace('[couple_title]', ucwords(strtolower(isset($couple->coupleProfile()->title) ? $couple->coupleProfile()->title : '')), $notification_vendor->subject);
            $notification_vendor_body = str_replace('[couple_title]', ucwords(strtolower(isset($couple->coupleProfile()->title) ? $couple->coupleProfile()->title : '')), $notification_vendor->body);
            Notification::route('mail', $emails)->notify(new GenericNotification([
                'title' => $notification_vendor_subject,
                'body' => $notification_vendor_body,
                'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $couple->id)),
                'btnTxt' => $notification_vendor->button,
                'notification_type' => $notification_vendor->type
            ]));

            foreach($dashboard_vendor as $dashboard) {
                $dashboard_subject = str_replace('[couple_title]', ucwords(strtolower(isset($couple->coupleProfile()->title) ? $couple->coupleProfile()->title : '')), $dashboard->subject);
                $dashboard_body = str_replace('[couple_title]', ucwords(strtolower(isset($couple->coupleProfile()->title) ? $couple->coupleProfile()->title : '')), $dashboard->body);
                
                $vendor->user->notify(new GenericNotification([
                    'title' => $dashboard_subject,
                    'body' => $dashboard_body,
                    'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $couple->id)),
                    'btnTxt' => $dashboard->button,
                    'notification_type' => $dashboard->type
                ]));
            }

            $notification_couple_subject = str_replace('[business_name]', ucwords(strtolower(isset($vendor->business_name) ? $vendor->business_name : '')), $notification_couple->subject);
            $notification_couple_body = str_replace('[business_name]', ucwords(strtolower(isset($vendor->business_name) ? $vendor->business_name : '')), $notification_couple->body);
            $couple->notify(new GenericNotification(
                [
                    'title' => $notification_couple_subject,
                    'body' => $notification_couple_body,
                    'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $vendor->user->id)),
                    'btnTxt' => $notification_couple->button,
                    'notification_type' => $notification_couple->type
                ]
            ));

            foreach($dashboard_couple as $dashboard) {
                $dashboard_subject = str_replace('[business_name]', ucwords(strtolower(isset($vendor->business_name) ? $vendor->business_name : '')), $dashboard->subject);
                $dashboard_body = str_replace('[business_name]', ucwords(strtolower(isset($vendor->business_name) ? $vendor->business_name : '')), $dashboard->body);
                
                $couple->notify(new GenericNotification([
                    'title' => $dashboard_subject,
                    'body' => $dashboard_body,
                    'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $vendor->user->id)),
                    'btnTxt' => $dashboard->button,
                    'notification_type' => $dashboard->type
                ]));
            }
        }
    }
}
