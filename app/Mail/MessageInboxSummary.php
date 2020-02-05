<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageInboxSummary extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $title;
    public $notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $notification)
    {
        $this->title = $title;
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
        $notification->body = str_replace('[title]', ucwords(strtolower(isset($this->title) ?$this->title : '')), $notification->body);

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.email-notification-main-template', compact('notification'));

    }
}
