<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\AdminEmailNotification;

class PasswordResetNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;
    public $notification;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $notification)
    {
        $this->token = $token;
        $this->notification = $notification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $notification = $this->notification;
        $notification->button_link = config('app.url').route('password.reset', $this->token, false);
        
        // AdminEmailNotification::create([
        //     'notification_event_id' => $notification->notification_event_id,
        //     'subject' => $notification->subject,
        //     'body' => $notification->body,
        // ]);

        return (new MailMessage)
            ->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($this->notification->subject)
            ->view('emails.email-notification-main-template', compact('notification'));
    }
}
