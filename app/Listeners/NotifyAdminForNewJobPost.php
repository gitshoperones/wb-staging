<?php

namespace App\Listeners;

use App\Mail\NewJobPost;
use App\Events\NewJobPosted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\NotificationContent;
class NotifyAdminForNewJobPost
{
    /**
     * Handle the event.
     *
     * @param  NewJobPosted  $event
     * @return void
     */
    public function handle(NewJobPosted $event)
    {
        $email_notification = (new NotificationContent)->getEmailContent('New Job Post', 'admin');
        Mail::to(config('mail.from.address'))->send(new NewJobPost($event->jobPost, $email_notification));
    }
}
