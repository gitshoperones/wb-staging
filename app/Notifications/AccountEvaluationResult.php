<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AccountEvaluationResult extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;
    public $notification;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $notification)
    {
        $this->notification = $notification;
        $this->user = User::whereId($user->id)->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($this->user->status === 'active') {
            return ['mail'];
        }

        return [];
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

        if ($this->user->status === 'active') {
            return (new MailMessage)
                ->from(config('mail.from.address'), 'The wedBooker Team')
                ->subject($this->notification->subject)
                ->view('emails.email-notification-main-template', compact('notification'));
        }
    }
}
