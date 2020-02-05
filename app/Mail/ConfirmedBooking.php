<?php

namespace App\Mail;

use App\Models\Couple;
use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\NotificationContent;

class ConfirmedBooking extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $vendor;
    public $couple;
    public $jobQuoteId;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Vendor $vendor, Couple $couple, $jobQuoteId, $type)
    {
        $this->vendor = $vendor;
        $this->couple = $couple;
        $this->jobQuoteId = $jobQuoteId;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $notification = (new NotificationContent)->getEmailContent('Booking Confirmed', $this->type);
        $notification->subject = str_replace('[business_name]', ucwords(strtolower(isset($this->vendor->business_name) ? $this->vendor->business_name : '')), $notification->subject);
        $notification->subject = str_replace('[couple_title]', ucwords(strtolower(isset($this->couple->title) ? $this->couple->title : '')), $notification->subject);
        $notification->body = str_replace('[business_name]', ucwords(strtolower(isset($this->vendor->business_name) ? $this->vendor->business_name : '')), $notification->body);
        $notification->body = str_replace('[couple_title]', ucwords(strtolower(isset($this->couple->title) ? $this->couple->title : '')), $notification->body);
        $notification->button_link = sprintf('/dashboard/job-quotes/%s', $this->jobQuoteId);

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.email-notification-main-template', compact('notification'));
    }
}
