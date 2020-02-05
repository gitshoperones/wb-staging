<?php

namespace App\Observers;

use App\Models\User;
use App\Models\JobPost;
use App\Models\JobQuote;
use App\Notifications\JobQuoteReceived;
use App\Helpers\NotificationContent;
class JobQuoteObserver
{
    public function created(JobQuote $jobQuote)
    {
        if ($jobQuote->status === 1) {
            $jobPost = JobPost::whereId($jobQuote->job_post_id)->firstOrFail(['user_id']);
            $jobPostOwner = User::whereId($jobPost->user_id)->firstOrFail(['id']);
            $email_notification = (new NotificationContent)->getEmailContent('New Job Quote', 'couple');
            $jobPostOwner->notify(new JobQuoteReceived($jobQuote, $jobPostOwner, $email_notification));
        }
    }
}
