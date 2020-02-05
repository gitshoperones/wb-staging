<?php

namespace App\Listeners;

use App\Mail\NewJobPost;
use App\Events\NewJobApproved;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\NotificationContent;
class NotifyAdminForNewJobApproved
{
    /**
     * Handle the event.
     *
     * @param  NewJobApproved  $event
     * @return void
     */
    public function handle(NewJobApproved $event)
    {
        $email_notification = (new NotificationContent)->getEmailContent('New Job Approved', 'admin');
        Mail::to(config('mail.from.address'))->send(new NewJobPost($event->jobPost, $email_notification));
    }
}
