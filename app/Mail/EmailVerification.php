<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Models\AdminEmailNotification;

class EmailVerification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $code;
    public $user;
    public $notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code, User $user, $notification)
    {
        $this->code = $code;
        $this->user = $user;
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
        $notification->button_link = url(sprintf('verify-email/%s', $this->code));

        AdminEmailNotification::create([
            'notification_event_id' => $notification->notification_event_id,
            'subject' => $notification->subject,
            'body' => $notification->body,
        ]);

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($this->notification->subject)
            ->view('emails.email-notification-main-template', compact('notification'));
    }
}
