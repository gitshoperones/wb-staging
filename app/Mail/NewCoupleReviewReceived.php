<?php

namespace App\Mail;

use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewCoupleReviewReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $vendor;
    public $couple_title;
    public $notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Vendor $vendor, $couple_title, $notification)
    {
        $this->vendor = $vendor;
        $this->couple_title = $couple_title;
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
        $notification->subject = str_replace('[couple_title]', ucwords(strtolower(isset($this->couple_title) ? $this->couple_title : '')), $notification->subject);
        $notification->body = str_replace('[couple_title]', ucwords(strtolower(isset($this->couple_title) ? $this->couple_title : '')), $notification->body);
        $notification->button_link = sprintf("/vendors/%s", $this->vendor->id);

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.email-notification-main-template', compact('notification'));
    }
}
