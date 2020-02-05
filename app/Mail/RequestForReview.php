<?php

namespace App\Mail;

use App\Models\Vendor;
use App\Models\VendorReview;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\NotificationContent;

class RequestForReview extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $vendor;
    public $review;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VendorReview $review, Vendor $vendor)
    {
        $this->review = $review;
        $this->vendor = $vendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $notification = (new NotificationContent)->getEmailContent('Request For Review', 'couple');
        $notification->subject = str_replace('[business_name]', ucwords(strtolower(isset($this->vendor->business_name) ? $this->vendor->business_name : '')), $notification->subject);
        $notification->body = str_replace('[reviewer_name]', ucwords(strtolower(isset($this->review->reviewer_name) ? $this->review->reviewer_name : '')), $notification->body);
        $notification->body = str_replace('[business_name]', ucwords(strtolower(isset($this->vendor->business_name) ? $this->vendor->business_name : '')), $notification->body);

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.request-for-review', compact('notification'));
    }
}
