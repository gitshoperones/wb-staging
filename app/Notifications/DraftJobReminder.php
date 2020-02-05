<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\NotificationSetting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Helpers\NotificationContent;

class DraftJobReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $title;
    public $body;
    public $btnTxt;
    public $btnLink;
    public $user;
    public $notification;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $data, User $user, $notification, $type)
    {
        $this->user = $user;
        $this->title = $data['title'];
        $this->body = $data['body'];
        $this->btnTxt = $data['btnTxt'] ?? null;
        $this->btnLink = $data['btnLink'] ?? null;
        $this->notification = $notification;
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
        $notification->button_link = $this->btnLink;

        return (new MailMessage)
            ->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.email-notification-main-template', compact('notification'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'btnTxt' => $this->btnTxt,
            'btnLink' => $this->btnLink
        ];
    }
}
