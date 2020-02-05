<?php

namespace App\Mail;

use App\Models\Vendor;
use App\Models\VendorReview;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\NotificationContent;
use App\Models\AdminEmailNotification;

class LowVendorReview extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $vendor;
    public $vendorReview;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Vendor $vendor, VendorReview $vendorReview)
    {
        $this->vendor = $vendor;
        $this->vendorReview = $vendorReview;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $notification = (new NotificationContent)->getEmailContent('Low Vendor Review', 'admin');
        $notification->body = str_replace('[business_name]', isset($this->vendor->business_name) ? $this->vendor->business_name : '', $notification->body);
        $notification->body = str_replace('[business_email]', isset($this->vendor->user->email) ? $this->vendor->user->email : '', $notification->body);
        $notification->body = str_replace('[reviewer_name]', isset($this->vendorReview->reviewer_name) ? $this->vendorReview->reviewer_name : '', $notification->body);
        $notification->body = str_replace('[event_type]', isset($this->vendorReview->event_type) ? $this->vendorReview->event_type : '', $notification->body);
        $notification->body = str_replace('[event_date]', isset($this->vendorReview->event_date) ? $this->vendorReview->event_date : '', $notification->body);
        $notification->body = str_replace('[average_rating]', isset($this->vendorReview->rating) ? $this->vendorReview->rating : '', $notification->body);
        $notification->body = str_replace('[easy_to_work_score]', isset($this->vendorReview->rating_breakdown['easy_to_work_with']) ? $this->vendorReview->rating_breakdown['easy_to_work_with'] : '', $notification->body);
        $notification->body = str_replace('[likely_to_recommend_score]', isset($this->vendorReview->rating_breakdown['likely_to_recoment_to_a_friend']) ? $this->vendorReview->rating_breakdown['likely_to_recoment_to_a_friend'] : '', $notification->body);
        $notification->body = str_replace('[overall_satisfaction]', isset($this->vendorReview->rating_breakdown['overall_satisfaction']) ? $this->vendorReview->rating_breakdown['overall_satisfaction'] : '', $notification->body);
        $notification->body = str_replace('[message]', isset($this->vendorReview->message) ? $this->vendorReview->message : '', $notification->body);

        AdminEmailNotification::create([
            'notification_event_id' => $notification->notification_event_id,
            'subject' => $notification->subject,
            'body' => $notification->body,
            'user_id' => $this->vendor->user->id
        ]);
        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.email-notification-admin-template', compact('notification'));
    }
}
