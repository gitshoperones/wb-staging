<?php

namespace App\Mail;

use App\Models\JobPost;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\AdminEmailNotification;

class NewJobPost extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $jobPost;
    public $notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(JobPost $jobPost, $notification)
    {
        $this->jobPost = $jobPost;
        $this->notification = $notification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $notification = $this->notification;
        $notification->body = str_replace('[user_profile_title]', $this->jobPost->userProfile->title, $notification->body);
        $notification->body = str_replace('[user_email]', $this->jobPost->user->email, $notification->body);
        $notification->body = str_replace('[category_name]', $this->jobPost->category->name, $notification->body);
        $notification->body = str_replace('[event_name]', $this->jobPost->event->name, $notification->body);
        $notification->body = str_replace('[location]',  $this->jobPost->locations->implode('name', ',&nbsp;'), $notification->body);
        $notification->body = str_replace('[event_date]', $this->jobPost->event_date ?: 'Not set', $notification->body);
        $notification->body = str_replace('[created_at]', $this->jobPost->created_at->format('d/m/Y'), $notification->body);
        $notification->body = str_replace('[updated_at]', $this->jobPost->updated_at->addWeeks(12)->format('d/m/Y'), $notification->body);
        
        if ($this->jobPost->job_type === 0) {
            $this->jobPost->job_type = 'Job Posted';
        } elseif ($this->jobPost->job_type === 1) {
            $this->jobPost->job_type = 'Quote Requested - Single';
        } elseif ($this->jobPost->job_type === 2) {
            $this->jobPost->job_type = 'Quote Requested - Multiple';
        }

        $notification->body = str_replace('[job_type]', $this->jobPost->job_type, $notification->body);
        
        AdminEmailNotification::create([
            'notification_event_id' => $notification->notification_event_id,
            'subject' => $notification->subject,
            'body' => $notification->body,
            'user_id' => $this->jobPost->user->id
        ]);
        
        return $this->subject($this->notification->subject)
            ->view('emails.email-notification-admin-template', compact('notification'));
    }
}
