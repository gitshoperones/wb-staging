<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Mail\NotificationsSummary;
use App\Models\NotificationSetting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class GenericNotification extends Notification
{
    use Queueable;

    public $data;
    public $user;
    public $notification_type;

    public function __construct(array $data, User $user = null)
    {
        $this->data = $data;
        $this->user = $user;
        $this->notification_type = (isset($this->data['notification_type'])) ? $this->data['notification_type'] : null;
        if (!is_null($this->notification_type)) {
            if ($this->notification_type == 'email') {
                if ($this->user && NotificationSetting::isImmidiate($this->user)) {
                    // Mail::to($this->user->email)->send(new NotificationsSummary($this->data));
                }
            }
        } else {
            // since we use database notification, we kept on getting duplicate entry
            // database error. To fix this, need to make database notification realtime
            // and then fire a separate email that is queueable .
            if ($this->user && NotificationSetting::isImmidiate($this->user)) {
                Mail::to($this->user->email)->send(new NotificationsSummary($this->data));
            }
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
        if (!is_null($this->notification_type)) {
            return ($this->notification_type == 'email')  ? ['mail'] : ['database'];
        } else {
            if (isset($this->data['sendMail']))
                return ['mail', 'database'];
            return ['database'];
        }
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
        return (new MailMessage)
            ->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($this->data['title'])
            ->view('emails.account-notification-summary', [
                'notification' => $this->data,
            ]);
    }
}
