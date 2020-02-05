<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Invoice;
use App\Mail\RefundRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\RefundRecord;
use Illuminate\Support\Facades\Auth;
use App\Helpers\MultipleEmails;
use App\Helpers\NotificationContent;
use App\Notifications\GenericNotification;
use Notification;

class RefundsController extends Controller
{
    public function store(Request $request, $invoiceId)
    {
        $invoice = Invoice::whereId($invoiceId)->with([
            'vendor',
            'jobQuote' => function ($q) {
                $q->with(['jobPost' => function ($q) {
                    $q->with([
                    'event',
                    'category',
                    'locations',
                    'propertyTypes',
                    'propertyFeatures',
                    'timeRequirement',
                    'userProfile:id,userA_id,title',
                ]);
                }]);
            }])->firstOrFail();

        RefundRecord::create([
            'invoice_id' => $invoice->id,
            'is_booking_canceled' => ($request->get('cancel_booking') == 'No') ? 0 : 1,
            'reason' => $request->get('reason'),
            'amount' => $request->get('amount'),
            'user_id' => Auth::id(),
            'status' => 1
        ]);

        $refunder = Auth::user()->account == "vendor" ? "Refund Requested by Business" : "Refund Requested by Couple" ;
        $email_notification = (new NotificationContent)->getEmailContent($refunder, 'admin');
        Mail::to(config('mail.from.address'))->send(new RefundRequest($invoice, $request->all(), $email_notification));
        
        $email_couple = (new NotificationContent)->getEmailContent($refunder, 'couple');
        $email_vendor = (new NotificationContent)->getEmailContent($refunder, 'vendor');
        $dashboard_couple = (new NotificationContent)->getNotificationContent($refunder, 'couple');
        $dashboard_vendor = (new NotificationContent)->getNotificationContent($refunder, 'vendor');
        
        //Couple
        $email_couple->subject = str_replace('[business_name]', ucwords($invoice->jobQuote->user->vendorProfile->business_name), $email_couple->subject);
        $email_couple->body = str_replace('[business_name]', ucwords($invoice->jobQuote->user->vendorProfile->business_name), $email_couple->body);

        $invoice->jobQuote->jobPost->user->notify(new GenericNotification([
            'title' => $email_couple->subject,
            'body' => $email_couple->body,
            'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $invoice->jobQuote->user->id)),
            'btnTxt' => $email_couple->button,
            'notification_type' => $email_couple->type
        ]));

        foreach ($dashboard_couple as $dashboard) {
            $dashboard->subject = str_replace('[business_name]', ucwords($invoice->jobQuote->user->vendorProfile->business_name), $dashboard->subject);
            $dashboard->body = str_replace('[business_name]', ucwords($invoice->jobQuote->user->vendorProfile->business_name), $dashboard->body);
            
            $invoice->jobQuote->jobPost->user->notify(new GenericNotification([
                'title' => $dashboard->subject,
                'body' => $dashboard->body,
                'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $invoice->jobQuote->user->id)),
                'btnTxt' => $dashboard->button,
                'notification_type' => $dashboard->type
            ]));
        }
        //Endcouple

        //Vendor
        $email_vendor->subject = str_replace('[couple_title]', ucwords($invoice->jobQuote->jobPost->user->coupleProfile()->title), $email_vendor->subject);
        $email_vendor->body = str_replace('[couple_title]', ucwords($invoice->jobQuote->jobPost->user->coupleProfile()->title), $email_vendor->body);

        $emails = (new MultipleEmails)->getMultipleEmails($invoice->jobQuote->user);

        Notification::route('mail', $emails)->notify(new GenericNotification([
            'title' => $email_vendor->subject,
            'body' => $email_vendor->body,
            'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $invoice->jobQuote->jobPost->user->id)),
            'btnTxt' => $email_vendor->button,
            'notification_type' => $email_vendor->type
        ]));

        foreach ($dashboard_vendor as $dashboard) {
            $dashboard->subject = str_replace('[couple_title]', ucwords($invoice->jobQuote->jobPost->user->coupleProfile()->title), $dashboard->subject);
            $dashboard->body = str_replace('[couple_title]', ucwords($invoice->jobQuote->jobPost->user->coupleProfile()->title), $dashboard->body);

            $invoice->jobQuote->user->notify(new GenericNotification([
                'title' => $dashboard->subject,
                'body' => $dashboard->body,
                'btnLink' => url(sprintf('/dashboard/messages?recipient_user_id=%s', $invoice->jobQuote->jobPost->user->id)),
                'btnTxt' => $dashboard->button,
                'notification_type' => $dashboard->type
            ]));
        }
        //Endvendor

        return redirect()->back()->with('modal_message', 'Your refund request was successfully sent');
    }
}
