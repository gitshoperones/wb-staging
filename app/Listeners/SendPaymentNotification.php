<?php

namespace App\Listeners;

use App\Mail\ConfirmedBooking;
use App\Events\CoupleSentPayment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\PaymentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\MultipleEmails;
use App\Helpers\NotificationContent;
use App\Notifications\GenericNotification;
use Notification;

class SendPaymentNotification
{
    public $amountReceived;
    public $coupleUser;
    public $vendorUser;
    public $invoice;
    public $payment;

    /**
     * Handle the event.
     *
     * @param  CoupleSentPayment  $event
     * @return void
     */
    public function handle(CoupleSentPayment $event)
    {
        $this->payment = $event->payment;
        $this->invoice = $event->payment->invoice->fresh();

        $this->coupleUser = $this->invoice->jobQuote->jobPost->user;
        $this->vendorUser = $this->invoice->jobQuote->user;

        $this->amountReceived = $this->payment->amount - $this->payment->fee;

        if ($this->invoice->status === 2) {
            $this->sendBalancePaymentNotification();
        } else {
            $this->sendDepositPaymentNotification();
        }

        $milestonesCount = $this->invoice->jobQuote->milestones->count();

        if ($milestonesCount === 1 || $this->invoice->status === 1) {
            $this->sendBookingConfirmation();
        }
    }

    public function sendDepositPaymentNotification()
    {
        $dashboard_couple = (new NotificationContent)->getNotificationContent('Booking Confirmed', 'couple');
        $dashboard_vendor = (new NotificationContent)->getNotificationContent('Booking Confirmed', 'vendor');

        foreach($dashboard_couple as $dashboard) {
            $dashboard->subject = str_replace('[business_name]', ucwords($this->invoice->jobQuote->user->vendorProfile->business_name), $dashboard->subject);

            $this->coupleUser->notify(new PaymentNotification([
                'account' => 'couple',
                'title' => $dashboard->subject,
                'body' => $dashboard->body,
                'btnLink' => url(sprintf('/dashboard/job-quotes/%s', $this->invoice->jobQuote->id)),
                'btnTxt' => $dashboard->button,
                'invoiceId' => $this->invoice->id,
                'amountPaid' => $this->payment->amount,
                'totalInvoice' => $this->invoice->total,
                'balance' => $this->invoice->balance,
                'businessName' => $this->invoice->jobQuote->user->vendorProfile->business_name,
                'jobCategory' => $this->invoice->jobQuote->jobPost->category->name,
                'type' => 'dashboard'
            ], $this->coupleUser));
        }

        foreach($dashboard_vendor as $dashboard) {
            $dashboard->body = str_replace('[couple_title]', ucwords($this->invoice->jobQuote->jobPost->user->coupleProfile()->title), $dashboard->body);

            $this->vendorUser->notify(new PaymentNotification([
                'account' => 'vendor',
                'title' => $dashboard->subject,
                'body' => $dashboard->body,
                'btnLink' => url(sprintf('/dashboard/job-quotes/%s', $this->invoice->jobQuote->id)),
                'btnTxt' => $dashboard->button,
                'invoiceId' => $this->invoice->id,
                'amountReceived' => $this->amountReceived,
                'paymentSent' => $this->payment->amount,
                'totalInvoice' => $this->invoice->total,
                'balance' => $this->invoice->balance,
                'fee' => $this->payment->fee,
                'coupleName' => $this->invoice->jobQuote->jobPost->user->coupleProfile()->title,
                'type' => 'dashboard'
            ], $this->vendorUser));
        }

    }

    public function sendBalancePaymentNotification()
    {
        $email_couple = (new NotificationContent)->getEmailContent('Balance Paid', 'couple');
        $email_vendor = (new NotificationContent)->getEmailContent('Balance Paid', 'vendor');
        $dashboard_couple = (new NotificationContent)->getNotificationContent('Balance Paid', 'couple');
        $dashboard_vendor = (new NotificationContent)->getNotificationContent('Balance Paid', 'vendor');

        $email_couple->subject = str_replace('[business_name]', ucwords($this->invoice->jobQuote->user->vendorProfile->business_name), $email_couple->subject);
        $email_couple->subject = str_replace('[couple_title]', ucwords($this->invoice->jobQuote->jobPost->user->coupleProfile()->title), $email_couple->subject);
        $email_couple->body = str_replace('[business_name]', ucwords($this->invoice->jobQuote->user->vendorProfile->business_name), $email_couple->body);
        $email_couple->body = str_replace('[couple_title]', ucwords($this->invoice->jobQuote->jobPost->user->coupleProfile()->title), $email_couple->body);

        $this->coupleUser->notify(new PaymentNotification([
            'account' => 'couple',
            'title' => $email_couple->subject,
            'body' => $email_couple->body,
            'btnLink' => url(sprintf('/dashboard/job-quotes/%s', $this->invoice->jobQuote->id)),
            'btnTxt' => $email_couple->button,
            'invoiceId' => $this->invoice->id,
            'amountPaid' => $this->payment->amount,
            'totalInvoice' => $this->invoice->total,
            'balance' => $this->invoice->balance,
            'businessName' => $this->invoice->jobQuote->user->vendorProfile->business_name,
            'jobCategory' => $this->invoice->jobQuote->jobPost->category->name,
            'type' => 'email'
        ], $this->coupleUser));

        foreach($dashboard_couple as $dashboard) {
            $dashboard->subject = str_replace('[business_name]', ucwords($this->invoice->jobQuote->user->vendorProfile->business_name), $dashboard->subject);

            $this->coupleUser->notify(new PaymentNotification([
                'account' => 'couple',
                'title' => $dashboard->subject,
                'body' => $dashboard->body,
                'btnLink' => url(sprintf('/dashboard/job-quotes/%s', $this->invoice->jobQuote->id)),
                'btnTxt' => $dashboard->button,
                'invoiceId' => $this->invoice->id,
                'amountPaid' => $this->payment->amount,
                'totalInvoice' => $this->invoice->total,
                'balance' => $this->invoice->balance,
                'businessName' => $this->invoice->jobQuote->user->vendorProfile->business_name,
                'jobCategory' => $this->invoice->jobQuote->jobPost->category->name,
                'type' => 'dashboard'
            ], $this->coupleUser));
        }

        $email_vendor->subject = str_replace('[business_name]', ucwords($this->invoice->jobQuote->user->vendorProfile->business_name), $email_vendor->subject);
        $email_vendor->subject = str_replace('[couple_title]', ucwords($this->invoice->jobQuote->jobPost->user->coupleProfile()->title), $email_vendor->subject);
        $email_vendor->body = str_replace('[business_name]', ucwords($this->invoice->jobQuote->user->vendorProfile->business_name), $email_vendor->body);
        $email_vendor->body = str_replace('[couple_title]', ucwords($this->invoice->jobQuote->jobPost->user->coupleProfile()->title), $email_vendor->body);
        
        $emails = (new MultipleEmails)->getMultipleEmails($this->vendorUser);

        Notification::route('mail', $emails)->notify(new PaymentNotification([
            'account' => 'vendor',
            'title' => $email_vendor->subject,
            'body' => $email_vendor->body,
            'btnLink' => url(sprintf('/dashboard/job-quotes/%s', $this->invoice->jobQuote->id)),
            'btnTxt' => $email_vendor->button,
            'invoiceId' => $this->invoice->id,
            'amountReceived' => $this->amountReceived,
            'paymentSent' => $this->payment->amount,
            'totalInvoice' => $this->invoice->total,
            'balance' => $this->invoice->balance,
            'fee' => $this->payment->fee,
            'coupleName' => $this->invoice->jobQuote->jobPost->user->coupleProfile()->title,
            'type' => 'email'
        ], $this->vendorUser));

        foreach($dashboard_vendor as $dashboard) {
            $dashboard->subject = str_replace('[couple_title]', ucwords($this->invoice->jobQuote->jobPost->user->coupleProfile()->title), $dashboard->subject);

            $this->vendorUser->notify(new PaymentNotification([
                'account' => 'vendor',
                'title' => $dashboard->subject,
                'body' => $dashboard->body,
                'btnLink' => url(sprintf('/dashboard/job-quotes/%s', $this->invoice->jobQuote->id)),
                'btnTxt' => $dashboard->button,
                'invoiceId' => $this->invoice->id,
                'amountReceived' => $this->amountReceived,
                'paymentSent' => $this->payment->amount,
                'totalInvoice' => $this->invoice->total,
                'balance' => $this->invoice->balance,
                'fee' => $this->payment->fee,
                'coupleName' => $this->invoice->jobQuote->jobPost->user->coupleProfile()->title,
                'type' => 'dashboard'
            ], $this->vendorUser));
        }

    }

    public function sendBookingConfirmation()
    {
        if ($this->invoice->status === 2) {
            $dashboard_couple = (new NotificationContent)->getNotificationContent('Booking Confirmed', 'couple');
            $dashboard_vendor = (new NotificationContent)->getNotificationContent('Booking Confirmed', 'vendor');
            
            foreach($dashboard_couple as $dashboard) {
                $dashboard->subject = str_replace('[business_name]', ucwords($this->invoice->jobQuote->user->vendorProfile->business_name), $dashboard->subject);
                
                $this->coupleUser->notify(new GenericNotification([
                    'title' => $dashboard->subject,
                    'body' => $dashboard->body,
                    'btnLink' => url(sprintf('/dashboard/job-quotes/%s', $this->invoice->jobQuote->id)),
                    'btnTxt' => $dashboard->button,
                    'type' => $dashboard->type
                ]));
            }

            foreach($dashboard_vendor as $dashboard) {
                $dashboard->body = str_replace('[couple_title]', ucwords($this->invoice->jobQuote->jobPost->user->coupleProfile()->title), $dashboard->body);
                
                $this->vendorUser->notify(new GenericNotification([
                    'title' => $dashboard->subject,
                    'body' => $dashboard->body,
                    'btnLink' => url(sprintf('/dashboard/job-quotes/%s', $this->invoice->jobQuote->id)),
                    'btnTxt' => $dashboard->button,
                    'type' => $dashboard->type
                ]));
            }
        }
        
        Mail::to($this->coupleUser->email)->send(new ConfirmedBooking(
            $this->invoice->jobQuote->user->vendorProfile,
            $this->invoice->jobQuote->jobPost->user->coupleProfile(),
            $this->invoice->jobQuote->id,
            'couple'
        ));

        $emails = (new MultipleEmails)->getMultipleEmails($this->vendorUser);

        return Mail::to($emails)->send(new ConfirmedBooking(
            $this->invoice->jobQuote->user->vendorProfile,
            $this->invoice->jobQuote->jobPost->user->coupleProfile(),
            $this->invoice->jobQuote->id,
            'vendor'
        ));
    }
}
