<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\NewJobQuote as NewJobQuoteEvent;
use App\Helpers\NotificationContent;
use App\Mail\NewJobQuote;
use Illuminate\Support\Facades\Mail;

class NotifyAdminNewJobQuote
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewJobQuoteEvent $event)
    {
        $email_notification = (new NotificationContent)->getEmailContent('New Job Quote', 'admin');
        Mail::to(config('mail.from.address'))->send(new NewJobQuote($event->jobQuote, $email_notification));

    }
}
