<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ParentAccountPasswordResetRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $token;
    public $businessName;
    public $notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $businessName, $notification)
    {
        $this->token = $token;
        $this->businessName = $businessName;
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
        $notification->body = str_replace('[business_name]', $this->businessName, $notification->body);
        $notification->subject  = str_replace('[business_name]', $this->businessName, $notification->subject);
        $notification->button_link = config('app.url').route('password.reset', $this->token, false);

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.email-notification-main-template', compact('notification'));
    }
}
