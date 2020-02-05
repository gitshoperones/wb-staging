<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\NotificationEvent;
use App\Models\EmailNotification;

class NotificationContent
{
    public function getEmailContent($eventType = null, $recipient = null)
    {
        $event = NotificationEvent::where('name', $eventType)->first();
        $notification = $event->email_notifications->where('recipient', $recipient)->first();

        return $notification;
    }

    public function getNotificationContent($eventType = null, $recipient = null)
    {
        $event = NotificationEvent::where('name', $eventType)->first();
        $dashboard_notification = $event->dashboard_notifications
            ->where('recipient', $recipient)
            ->where('status', 1)
            ->all();

        return $dashboard_notification;
    }
}
