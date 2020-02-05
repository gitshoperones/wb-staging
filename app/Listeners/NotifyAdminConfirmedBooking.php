<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\AdminConfirmedBooking as AdminConfirmedBookingEvent;
use App\Helpers\NotificationContent;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminConfirmedBooking;

class NotifyAdminConfirmedBooking
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    // public function handle(AdminConfirmedBookingEvent $event)
    public function handle()
    {
        $email_notification = (new NotificationContent)->getEmailContent('Balance Paid', 'admin'); #change to Booking Confirmed
        // Mail::to(config('mail.from.address'))->send(new AdminConfirmedBooking($event->payment, $email_notification));
        Mail::to(config('mail.from.address'))->send(new AdminConfirmedBooking($email_notification));
    }
}
