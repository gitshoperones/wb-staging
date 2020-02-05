<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\AdminEmailNotification;

class AdminConfirmedBooking extends Mailable
{
    use Queueable, SerializesModels;

    public $notification;
    // public $payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public function __construct($payment, $notification)
    public function __construct($notification)
    {
        // $this->payment = $payment;
        $this->notification = $notification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $payment = $this->payment;
        $notification = $this->notification;
        AdminEmailNotification::create([
            'notification_event_id' => $notification->notification_event_id,
            'subject' => $notification->subject,
            'body' => $notification->body,
        ]);

        return $this->subject($this->notification->subject)
            ->view('emails.email-notification-admin-template', compact('notification'));
    }
}
