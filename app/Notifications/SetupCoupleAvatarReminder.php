<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Helpers\NotificationContent;

class SetupCoupleAvatarReminder extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
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
        $title = $body = $btnTxt = '';
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Email Verified - Profile Picture', 'couple');
        foreach ($dashboard_notifications as $dashboard_notification) {
            $title = $dashboard_notification->subject;
            $body = $dashboard_notification->body;
            $btnTxt = $dashboard_notification->button;
        }
        
        return [
            'title' => $title,
            'body' => $body,
            'btnTxt' => $btnTxt,
        ];
    }
}
