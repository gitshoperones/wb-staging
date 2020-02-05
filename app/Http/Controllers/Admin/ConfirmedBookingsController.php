<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Search\ConfirmedBooking\ConfirmedBookingSearchManager;
use App\Models\Invoice;
use App\Notifications\GenericNotification;
use App\Helpers\MultipleEmails;
use App\Helpers\NotificationContent;
use Notification;

class ConfirmedBookingsController extends Controller
{
    public function index()
    {
        $filters = request()->all();
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

        ];

        $confirmedBookings = ConfirmedBookingSearchManager::keywordSearch(request('search'));

        return view('admin.confirmed-bookings.index', compact('confirmedBookings'));
    }

    public function cancel(Request $request, Invoice $invoice)
    {
        $invoice->update([
            'is_cancelled' => $request->is_cancelled, 
            'cancelled_reason' => $request->cancelled_reason
        ]);

        if ($request->is_cancelled) {
            $email_vendor = (new NotificationContent)->getEmailContent('Booking Cancelled', 'vendor');
            $email_couple = (new NotificationContent)->getEmailContent('Booking Cancelled', 'couple');
            $dashboard_vendor = (new NotificationContent)->getNotificationContent('Booking Cancelled', 'vendor');
            $dashboard_couple = (new NotificationContent)->getNotificationContent('Booking Cancelled', 'couple');

            $emails = (new MultipleEmails)->getMultipleEmails($invoice->vendor->user);
            
            $email_vendor->subject = str_replace('[couple_title]', ucwords($invoice->couple->title), $email_vendor->subject);
            $email_vendor->body = str_replace('[couple_title]', ucwords($invoice->couple->title), $email_vendor->body);

            Notification::route('mail', $emails)->notify(new GenericNotification(
                [
                    'title' => $email_vendor->subject,
                    'body' => $email_vendor->body,
                    'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $invoice->couple->userB->id)),
                    'btnTxt' => $email_vendor->button,
                    'notification_type' => $email_vendor->type
                ]
            ));
            
            foreach($dashboard_vendor as $dashboard) {
                $dashboard->subject = str_replace('[couple_title]', ucwords($invoice->couple->title), $dashboard->subject);
                $dashboard->body = str_replace('[couple_title]', ucwords($invoice->couple->title), $dashboard->body);

                $invoice->vendor->user->notify(new GenericNotification(
                    [
                        'title' => $dashboard->subject,
                        'body' => $dashboard->body,
                        'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $invoice->couple->userB->id)),
                        'btnTxt' => $dashboard->button,
                        'notification_type' => $dashboard->type
                    ]
                ));
            }

            $email_couple->subject = str_replace('[business_name]', ucwords($invoice->vendor->business_name), $email_couple->subject);
            $email_couple->body = str_replace('[business_name]', ucwords($invoice->vendor->business_name), $email_couple->body);

            $invoice->couple->userB->notify(new GenericNotification(
                [
                    'title' => $email_couple->subject,
                    'body' => $email_couple->body,
                    'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $invoice->vendor->user->id)),
                    'btnTxt' => $email_couple->button,
                    'notification_type' => $email_couple->type
                ]
            ));
            
            foreach($dashboard_couple as $dashboard) {
                $dashboard->subject = str_replace('[business_name]', ucwords($invoice->vendor->business_name), $dashboard->subject);
                $dashboard->body = str_replace('[business_name]', ucwords($invoice->vendor->business_name), $dashboard->body);
                
                $invoice->couple->userB->notify(new GenericNotification(
                    [
                        'title' => $dashboard->subject,
                        'body' => $dashboard->body,
                        'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $invoice->vendor->user->id)),
                        'btnTxt' => $dashboard->button,
                        'notification_type' => $dashboard->type
                    ]
                ));
            }
        }
        
        return back()->with('success_message', 'Successfully updated booking!');
    }

    public function refund(Request $request, Invoice $invoice)
    {
        $invoice->update([
            'is_refunded' => $request->is_refunded
        ]);

        if ($request->is_refunded) {
            $email_vendor = (new NotificationContent)->getEmailContent('Booking Refunded', 'vendor');
            $email_couple = (new NotificationContent)->getEmailContent('Booking Refunded', 'couple');
            $dashboard_vendor = (new NotificationContent)->getNotificationContent('Booking Refunded', 'vendor');
            $dashboard_couple = (new NotificationContent)->getNotificationContent('Booking Refunded', 'couple');
            
            $emails = (new MultipleEmails)->getMultipleEmails($invoice->vendor->user);

            $email_vendor->subject = str_replace('[couple_title]', ucwords($invoice->couple->title), $email_vendor->subject);
            $email_vendor->body = str_replace('[couple_title]', ucwords($invoice->couple->title), $email_vendor->body);

            Notification::route('mail', $emails)->notify(new GenericNotification(
                [
                    'title' => $email_vendor->subject,
                    'body' => $email_vendor->body,
                    'btnLink' => $email_vendor->button_link,
                    'btnTxt' => $email_vendor->button,
                    'notification_type' => $email_vendor->type
                ]
            ));

            foreach($dashboard_vendor as $dashboard) {
                $dashboard->subject = str_replace('[couple_title]', ucwords($invoice->couple->title), $dashboard->subject);
                $dashboard->body = str_replace('[couple_title]', ucwords($invoice->couple->title), $dashboard->body);

                $invoice->vendor->user->notify(new GenericNotification(
                    [
                        'title' => $dashboard->subject,
                        'body' => $dashboard->body,
                        'btnLink' => $dashboard->button_link,
                        'btnTxt' => $dashboard->button,
                        'notification_type' => $dashboard->type
                    ]
                ));
            }

            $email_couple->subject = str_replace('[business_name]', ucwords($invoice->vendor->business_name), $email_couple->subject);
            $email_couple->body = str_replace('[business_name]', ucwords($invoice->vendor->business_name), $email_couple->body);

            $invoice->couple->userB->notify(new GenericNotification(
                [
                    'title' => $email_couple->subject,
                    'body' => $email_couple->body,
                    'btnLink' => $dashboard->button_link,
                    'btnTxt' => $email_couple->button,
                    'notification_type' => $email_couple->type
                ]
            ));
            
            foreach($dashboard_couple as $dashboard) {
                $dashboard->subject = str_replace('[business_name]', ucwords($invoice->vendor->business_name), $dashboard->subject);
                $dashboard->body = str_replace('[business_name]', ucwords($invoice->vendor->business_name), $dashboard->body);
                
                $invoice->couple->userB->notify(new GenericNotification(
                    [
                        'title' => $dashboard->subject,
                        'body' => $dashboard->body,
                        'btnLink' => $dashboard->button_link,
                        'btnTxt' => $dashboard->button,
                        'notification_type' => $dashboard->type
                    ]
                ));
            }
        }

        return back()->with('success_message', 'Successfully updated booking!');
    }
}
