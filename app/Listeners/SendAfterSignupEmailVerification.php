<?php

namespace App\Listeners;

use App\Events\NewUserSignedUp;
use App\Helpers\ActivationCode;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\NotificationContent;

class SendAfterSignupEmailVerification
{
    /**
     * Handle the event.
     *
     * @param  NewUserSignedUp  $event
     * @return void
     */
    public function handle(NewUserSignedUp $event)
    {
        $user = $event->user;
        $activation = (new ActivationCode)->create()->assignTo($user);

        $email_notification = (new NotificationContent)->getEmailContent('New User Sign Up', 'vendor,couple');

        return Mail::to($user->email)->send(new EmailVerification($activation->code, $user, $email_notification));
    }
}
