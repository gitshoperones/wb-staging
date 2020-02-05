<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AccountNotificationSummary extends Notification implements ShouldQueue
{
    use Queueable;

    public $frequency;
    public $notifications;
    public $notification;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notifications = [], $frequency = 'once daily', $notification)
    {
        $this->notifications = $notifications;
        $this->frequency = $frequency;
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
        $new = ($this->frequency === 'twicey daily') ? 'New! ': '';
        
        return (new MailMessage)
            ->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($new . $notification->subject)
            ->view('emails.email-notification-main-template', [
                'notification' => $notification,
            ]);
    }
}
