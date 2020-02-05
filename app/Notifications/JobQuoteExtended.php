<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\JobPost;
use App\Models\JobQuote;
use Illuminate\Bus\Queueable;
use App\Models\NotificationSetting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Helpers\NotificationContent;

class JobQuoteExtended extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;
    public $title;
    public $body;
    public $jobQuote;
    public $jobPost;
    public $jobQuoteOwnerProfile;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(JobQuote $jobQuote, User $user)
    {
        $this->user = $user;
        $this->jobQuote = $jobQuote;
        $this->jobPost = JobPost::whereId($jobQuote->job_post_id)
            ->with('category', 'userProfile')->first(['id', 'user_id', 'category_id']);
        $this->jobQuoteOwnerProfile = $this->jobQuote->user->vendorProfile;

        $this->setData();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (NotificationSetting::isImmidiate($this->user)) {
            return ['mail', 'database'];
        }

        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $notification = (new NotificationContent)->getEmailContent('Job Quote Extended', 'couple');
        $notification->subject = str_replace('[business_name]', isset($this->jobQuoteOwnerProfile->business_name) ? $this->jobQuoteOwnerProfile->business_name : '', $notification->subject);

        return (new MailMessage)
            ->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject(ucfirst(strtolower($this->title)))
            ->view('emails.email-notification-main-template', compact('notification'));
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'quoteOwnerAvatar' => $this->jobQuoteOwnerProfile->profile_avatar,
            'jobQuoteId' => $this->jobQuote->id,
            'jobPostId' => $this->jobPost->id
        ];
    }

    public function setData()
    {
        $this->title = $this->body = '';
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Job Quote Extended', 'couple');
        foreach ($dashboard_notifications as $dashboard_notification) {
            $this->title = $dashboard_notification->subject = str_replace('[business_name]', isset($this->jobQuoteOwnerProfile->business_name) ? $this->jobQuoteOwnerProfile->business_name : '', $dashboard_notification->subject);
            $this->body = $dashboard_notification->body;
        }

        return $this;
    }
}
