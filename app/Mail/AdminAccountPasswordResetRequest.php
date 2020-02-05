<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\AdminEmailNotification;

class AdminAccountPasswordResetRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $token;
    public $notification;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $notification)
    {
        $this->token = $token;
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
        $notification->button_link = config('app.url').route('password.reset', $this->token, false);

        AdminEmailNotification::create([
            'notification_event_id' => $notification->notification_event_id,
            'subject' => $notification->subject,
            'body' => $notification->body,
        ]);

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.email-notification-main-template', compact('notification'));
    }
}
