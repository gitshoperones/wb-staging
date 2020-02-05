<?php

namespace App\Listeners;

use App\Mail\NewUserSignup;
use App\Events\NewUserSignedUp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\NotificationContent;

class NotifyAdminAfterUserSignup
{
    /**
     * Handle the event.
     *
     * @param  NewUserSignedUp  $event
     * @return void
     */
    public function handle(NewUserSignedUp $event)
    {
        $email_notification = (new NotificationContent)->getEmailContent('New User Sign Up', 'admin');
        Mail::to(config('mail.from.address'))->send(new NewUserSignup($event->user, $email_notification));
    }
}
