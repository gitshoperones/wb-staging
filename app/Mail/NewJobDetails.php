<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
// use App\Models\NotificationEvent;

class NewJobDetails extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;
    public $notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $notification)
    {
        $this->data = $data;
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
        $notification->subject = str_replace('[couple_name]', $this->data['jobDetails']['couple'], $notification->subject);
        $notification->body = str_replace('[couple_name]', $this->data['jobDetails']['couple'], $notification->body);
        $notification->body = str_replace('[category]', $this->data['jobDetails']['category'], $notification->body);
        $notification->body = str_replace('[location]', $this->data['jobDetails']['location'], $notification->body);
        $notification->body = str_replace('[date]', $this->data['jobDetails']['date'] ?: 'Not specified', $notification->body);
        $notification->body = str_replace('[flexible_date]', $this->data['jobDetails']['flexibleDate'] ? '(Flexible with dates)' : '', $notification->body);
        $notification->body = str_replace('[budget]', $this->data['jobDetails']['budget'] ? '$' : 'Not specified', $notification->body);
        $notification->body = str_replace('[event]', $this->data['jobDetails']['event'], $notification->body);
        $notification->button_link = $this->data['btnLink'];

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.email-notification-main-template', compact('notification'));
    }
}
