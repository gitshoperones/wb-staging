<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CustomNotification extends Notification
{
    use Queueable;

    public $data;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $data, $type)
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($this->type == 'email')
            return ['mail'];

        return ['database'];

        // if (isset($this->data['sendMail']))
        //     return ['mail', 'database'];

        // return ['database'];
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
        $this->body = "<p><strong>{$this->data['title']}</strong></p><p>{$this->data['body']}</p>";
        return (new MailMessage)
            ->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($this->data['title'])
            ->view('emails.account-notification-summary', [
                'notification' => $this->data,
            ]);
    }
}
