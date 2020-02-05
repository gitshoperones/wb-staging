<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\NotificationSetting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Helpers\NotificationContent;

class JobQuoteReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $title;
    public $body;
    public $btnTxt;
    public $btnLink;
    public $business_name;
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
        $this->business_name = $data['business_name'] ?? null;
        $this->title = str_replace('[business_name]', ucwords(strtolower(isset($this->business_name) ? $this->business_name : '')), $data['title']);
        $this->body = str_replace('[business_name]', ucwords(strtolower(isset($this->business_name) ? $this->business_name : '')), $data['body']);
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
        $notification = $this->notification;
        $notification->subject = str_replace('[business_name]', ucwords(strtolower(isset($this->business_name) ? $this->business_name : '')), $notification->subject);
        $notification->body = str_replace('[business_name]', ucwords(strtolower(isset($this->business_name) ? $this->business_name : '')), $notification->body);
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
