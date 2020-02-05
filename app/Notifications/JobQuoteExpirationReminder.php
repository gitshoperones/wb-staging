<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\NotificationSetting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class JobQuoteExpirationReminder extends Notification implements ShouldQueue
{
    use Queueable;

    use Queueable;

    public $data;
    public $user;
    public $type;

    public function __construct(array $data, User $user, $type)
    {
        $this->user = $user;
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

        // if (NotificationSetting::isImmidiate($this->user)) {
        //     return ['mail', 'database'];
        // }

        // return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject(ucwords(strtolower($this->data['title'])))
            ->view('emails.account-notification-summary', [
                'notification' => $this->data,
            ]);
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->data['title'],
            'body' => $this->data['body'],
            'btnTxt' => $this->data['btnTxt'],
            'btnLink' => $this->data['btnLink']
        ];
    }
}
