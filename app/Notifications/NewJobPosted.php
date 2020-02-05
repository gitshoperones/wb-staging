<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\JobPost;
use Illuminate\Bus\Queueable;
use App\Mail\NewJobDetails;
use App\Models\NotificationSetting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Helpers\MultipleEmails;
use App\Helpers\NotificationContent;

class NewJobPosted extends Notification
{
    use Queueable;

    public $data;
    public $user;

    public function __construct(array $data, User $user)
    {
        $this->user = $user;
        $this->data = $data;

        // since we use database notification, we kept on getting duplicate entry
        // database error. To fix this, need to make database notification realtime
        // and then fire a separate email that is queueable .
        if ($this->user && NotificationSetting::isImmidiate($this->user)) {
            $emails = ($this->user->account == 'vendor') ? (new MultipleEmails)->getMultipleEmails($this->user) : $this->user->email;
            $jobPost = JobPost::where('id', $data['jobPostId'])->first();
            
            $trigger = 'New Job Approved';
            if ($jobPost->job_type === 1) {
                $trigger = 'New Job Request - Single';
            } elseif ($jobPost->job_type === 2) {
                $trigger = 'New Job Request - Multiple';
            }

            $email_notification = (new NotificationContent)->getEmailContent($trigger, 'vendor');
            Mail::to($emails)->send(new NewJobDetails($this->data, $email_notification));
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return $this->data;
    }
}
