<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddVendorReviewEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $coupleTitle;
    public $vendorTitle;
    public $jobQuoteId;
    public $code;
    public $notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data, $notification)
    {
        $this->coupleTitle = $data['coupleTitle'];
        $this->vendorTitle = $data['vendorTitle'];
        $this->jobQuoteId = $data['jobQuoteId'];
        $this->code = $data['code'];
        $this->notification = $notification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $notification = $this->notification;
        $notification->subject = str_replace('[couple_title]', ucwords(strtolower(isset($this->coupleTitle) ? $this->coupleTitle : '')), $notification->subject);
        $notification->subject = str_replace('[vendor_title]', ucwords(strtolower(isset($this->vendorTitle) ? $this->vendorTitle : '')), $notification->subject);
        $notification->body = str_replace('[couple_title]', ucwords(strtolower(isset($this->coupleTitle) ? $this->coupleTitle : '')), $notification->body);
        $notification->body = str_replace('[vendor_title]', ucwords(strtolower(isset($this->vendorTitle) ? $this->vendorTitle : '')), $notification->body);
        $notification->button_link = sprintf('/vendor-review/%s?job-quote-id=%s', $this->code, $this->jobQuoteId);

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.email-notification-main-template', compact('notification'));
    }
}
