<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\NotificationContent;

class Payment extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $notification = (new NotificationContent)->getEmailContent('Payment Made', $this->data['account']);
        $notification->body = str_replace('[business_name]', isset($this->data['businessName']) ? $this->data['businessName'] : '', $notification->body);
        $notification->body = str_replace('[couple_title]', isset($this->data['coupleName']) ? $this->data['coupleName'] : '', $notification->body);
        $notification->body = str_replace('[category]', isset($this->data['jobCategory']) ? $this->data['jobCategory'] : '', $notification->body);
        $notification->body = str_replace('[booking_amount]', isset($this->data['totalInvoice']) ? number_format($this->data['totalInvoice'], 2) : '' , $notification->body);
        $notification->body = str_replace('[amount_paid]', isset($this->data['amountPaid']) ? number_format($this->data['amountPaid'], 2) : '', $notification->body);
        $notification->body = str_replace('[balance]', isset($this->data['balance']) ? number_format($this->data['balance'], 2) : '', $notification->body);
        $notification->body = str_replace('[invoice_link]', url(sprintf('/invoice/%s/pdf', $this->data['invoiceId'])), $notification->body);
        $notification->body = str_replace('[payment_received]', isset($this->data['paymentSent']) ? number_format($this->data['paymentSent'], 2) : '', $notification->body);
        $notification->body = str_replace('[amount_received]', isset($this->data['amountReceived']) ? number_format($this->data['amountReceived'], 2) : '', $notification->body);
        $notification->body = str_replace('[wedbooker_fee]', isset($this->data['fee']) ? number_format($this->data['fee'], 2) : '', $notification->body);

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.email-notification-payment-template', compact('notification'));
    }
}
