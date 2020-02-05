<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SuperAdminAccountPasswordResetRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;
    public $notification;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $token, $notification)
    {
        $this->user = $user;
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
        $user = $this->user;
        $token = $this->token;
        $notification = $this->notification;

        $notification->body = str_replace('[email]', ucwords(strtolower($user->email)), $notification->body);
        $notification->body = str_replace('[first_name]', ucwords(strtolower($user->fname)), $notification->body);
        $notification->body = str_replace('[last_name]', ucwords(strtolower($user->lname)), $notification->body);

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.email-notification-admin-template', compact('notification'));
    }
}
