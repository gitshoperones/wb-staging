<?php

namespace App\Listeners;

use App\Models\Vendor;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewCoupleReviewReceived;
use App\Events\CoupleSubmittedNewReview;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\VendorReceivedNewReview;
use App\Helpers\MultipleEmails;
use App\Helpers\NotificationContent;
use Notification;

class NotifyVendorForNewReview
{
    /**
     * Handle the event.
     *
     * @param  CoupleSubmittedNewReview  $event
     * @return void
     */
    public function handle(CoupleSubmittedNewReview $event)
    {
        $vendor = Vendor::whereId($event->vendorReview->vendor_id)->with('user')->firstOrFail();
        $emails = (new MultipleEmails)->getMultipleEmails($vendor->user);
        
        $email_notification = (new NotificationContent)->getEmailContent('Review Received', 'vendor');
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Review Received', 'vendor');

        Mail::to($emails)->send(new NewCoupleReviewReceived($vendor, $event->vendorReview->reviewer_name, $email_notification));
        foreach($dashboard_notifications as $dashboard_notification) {
            $dashboard_notification->subject = str_replace('[couple_title]', ucwords(strtolower(isset($event->vendorReview->reviewer_name) ? $event->vendorReview->reviewer_name : '')), $dashboard_notification->subject);
            $dashboard_notification->body = str_replace('[couple_title]', ucwords(strtolower(isset($event->vendorReview->reviewer_name) ? $event->vendorReview->reviewer_name : '')), $dashboard_notification->body);

            $vendor->user->notify(new VendorReceivedNewReview([
                'title' => $dashboard_notification->subject,
                'body' => $dashboard_notification->body,
                'review' => $event->vendorReview
            ]));
        }
    }
}
