<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
// use App\Models\NotificationEvent;

class JobPostUpdated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $notification;
    public $jobPost;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $notification, $jobPost)
    {
        $this->user = $user;
        $this->notification = $notification;
        $this->jobPost = $jobPost;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $notification = $this->notification;
        $jobPost = $this->jobPost;
        $notification->subject = str_replace('[category]', ucwords(strtolower(isset($jobPost->category->name) ? $jobPost->category->name : '')), $notification->subject);
        $notification->subject = str_replace('[couple_name]', ucwords(strtolower(isset($jobPost->user->coupleProfile()->title) ? $jobPost->user->coupleProfile()->title : '')), $notification->subject);
        $notification->button_link = sprintf('/dashboard/job-posts/%s', $jobPost->id);

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.email-notification-main-template', compact('notification'));
    }
}
