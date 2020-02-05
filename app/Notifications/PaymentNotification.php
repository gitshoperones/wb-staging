<?php

namespace App\Notifications;

use App\Models\User;
use App\Mail\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Helpers\MultipleEmails;

class PaymentNotification extends Notification
{
    use Queueable;

    public $data;
    public $user;

    public function __construct(array $data, User $user)
    {
        $this->data = $data;
        $this->user = $user;

        // since we use database notification, we kept on getting duplicate entry
        // database error. To fix this, need to make database notification realtime
        // and then fire a separate email that is queueable .
        if ($this->user && $this->data['type'] == 'dashboard') {
            $emails = ($this->user->account == 'vendor') ? (new MultipleEmails)->getMultipleEmails($this->user) : $this->user->email;
            Mail::to($emails)->send(new Payment($this->data));
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if($this->data['type'] == 'email')
            return ['mail'];

        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return $this->data;
    }

    public function toMail($notifiable)
    {
        $notification = (object) [];
        $notification->subject = $this->data['title'];
        $notification->body = $this->data['body'];
        $notification->button = $this->data['btnTxt'];
        $notification->button_link = $this->data['btnLink'];

        return (new MailMessage)
            ->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($this->data['title'])
            ->view('emails.email-notification-main-template', compact('notification'));
    }
}
