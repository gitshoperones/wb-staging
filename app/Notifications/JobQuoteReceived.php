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

class JobQuoteReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;
    public $title;
    public $body;
    public $jobQuote;
    public $jobPost;
    public $jobQuoteOwnerProfile;
    public $notification;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(JobQuote $jobQuote, User $user, $notification)
    {
        $this->user = $user;
        $this->jobQuote = $jobQuote;
        $this->jobPost = JobPost::whereId($jobQuote->job_post_id)
            ->with('event', 'category', 'userProfile')
            ->first(['id', 'event_id', 'user_id', 'category_id']);
        $this->jobQuoteOwnerProfile = $this->jobQuote->user->vendorProfile;
        $this->notification = $notification;

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
        $notification = $this->notification;
        $notification->subject = str_replace('[business_name]', ucwords(strtolower($this->jobQuoteOwnerProfile->business_name)), $notification->subject);
        $notification->body = str_replace('[category_name]', $this->jobPost->category->name, $notification->body);
        $notification->body = str_replace('[event_name]', $this->jobPost->event->name, $notification->body);
        $notification->button_link = sprintf('/dashboard/job-quotes/%s', $this->jobQuote->id);

        return (new MailMessage)
            ->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
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
        // $notification = $this->notification;
        // $notification->subject = str_replace('[business_name]', ucwords(strtolower($this->jobQuoteOwnerProfile->business_name)), $notification->subject);
        // $notification->body = str_replace('[category_name]', $this->jobPost->category->name, $notification->body);
        // $notification->body = str_replace('[event_name]', $this->jobPost->event->name, $notification->body);

        return [
            // 'title' => $notification->title,
            // 'body' => $notification->body,
            'title' => $this->title,
            'body' => $this->body,
            'quoteOwnerAvatar' => $this->jobQuoteOwnerProfile->profile_avatar,
            'jobQuoteId' => $this->jobQuote->id,
            'jobPostId' => $this->jobPost->id
        ];
    }

    public function setData()
    {
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('New Job Quote', 'couple');
        foreach ($dashboard_notifications as $dashboard_notification) {
            $this->title = $dashboard_notification->subject = str_replace('[business_name]', ucwords(strtolower(isset($this->jobQuoteOwnerProfile->business_name) ? $this->jobQuoteOwnerProfile->business_name : '')), $dashboard_notification->subject);
            $this->body = $dashboard_notification->body = str_replace('[category_name]', isset($this->jobPost->category->name) ? $this->jobPost->category->name : '', $dashboard_notification->body);
            $this->body = $dashboard_notification->body = str_replace('[event_name]', isset($this->jobPost->event->name) ? $this->jobPost->event->name : '', $dashboard_notification->body);
        }

        // $this->title = sprintf('Quote from %s', ucwords(strtolower($this->jobQuoteOwnerProfile->business_name)));
        // $this->body = sprintf(
        //     'You have received a quote for your "%s" job for your "%s"',
        //     $this->jobPost->category->name,
        //     $this->jobPost->event->name
        // );

        return $this;
    }
}
