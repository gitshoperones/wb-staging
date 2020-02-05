<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\NotificationContent;

class NewUserSignup extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $notification)
    {
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
        $user = $this->user;
        $user->fname = ($user->fname == '') ? '--' : $user->fname;
        $user->lname = ($user->lname == '') ? '--' : $user->lname;

        $notification->body = str_replace('[user_type]', $user->account, $notification->body);
        $notification->body = str_replace('[user_email]', $user->email, $notification->body);
        $notification->body = str_replace('[user_fname]', $user->fname, $notification->body);
        $notification->body = str_replace('[user_lname]', $user->lname, $notification->body);

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.email-notification-admin-template', compact('notification'));
    }
}
