<?php

namespace App\Listeners;

use App\Events\NewUserSignedUp;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\GenericNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\SetupCoupleAvatarReminder;
use App\Helpers\NotificationContent;

class SendAfterSignupNotifications
{
    public $user;

    /**
     * Handle the event.
     *
     * @param  NewUserSignedUp  $event
     * @return void
     */
    public function handle(NewUserSignedUp $event)
    {
        $this->user = $event->user;

        if ($this->user->account === 'couple') {
            return $this->coupleNotifications();
        }

        if ($this->user->account === 'vendor') {
            return $this->vendorNotifications();
        }
    }

    public function coupleNotifications()
    {
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Email Verified', 'couple');
        foreach ($dashboard_notifications as $dashboard_notification) {
            $this->user->notify(new GenericNotification([
                'title' => $dashboard_notification->subject,
                'body' => $dashboard_notification->body,
                'btnLink' => $dashboard_notification->button_link,
                'btnTxt' => $dashboard_notification->button,
                'btnLink2' => $dashboard_notification->button_link2,
                'btnTxt2' => $dashboard_notification->button2
            ]));
            sleep(1);
        }

        $this->user->notify(new SetupCoupleAvatarReminder);
    }

    public function vendorNotifications()
    {
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Email Verified', 'vendor');
        foreach ($dashboard_notifications as $dashboard_notification) {
            $dashboard_notification->button_link = sprintf('/vendors/%s/edit', $this->user->vendorProfile->id);
            $this->user->notify(new GenericNotification([
                'title' => $dashboard_notification->subject,
                'body' => $dashboard_notification->body,
                'btnLink' => $dashboard_notification->button_link,
                'btnTxt' => $dashboard_notification->button
            ]));
        }
    }
}
