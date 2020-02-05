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

class JobQuoteResponse extends Notification implements ShouldQueue
{
    use Queueable;

    public $title;
    public $body;
    public $jobQuote;
    public $jobPost;
    public $user;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(JobQuote $jobQuote, User $user, $type)
    {
        $this->user = $user;
        $this->jobQuote = $jobQuote;
        $this->jobPost = JobPost::whereId($jobQuote->job_post_id)
            ->with('userProfile')->first(['id', 'user_id', 'category_id']);
        $this->type = $type;

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
        if ($this->type == 'email')
            return ['mail'];

        return ['database'];

        // if (NotificationSetting::isImmidiate($this->user)) {
        //     return ['mail', 'database'];
        // }

        // return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $notification = '';
        if ($this->jobQuote->status === 3) { //Accepted
            $notification = (new NotificationContent)->getEmailContent('Job Quote Response - accepted', 'vendor');
            $notification->subject = str_replace('[couple_title]', ucwords(strtolower(isset($this->jobPost->userProfile->title) ? $this->jobPost->userProfile->title : '')), $notification->subject);
            
            // $this->title = sprintf('%s have accepted your quote', ucwords(strtolower($this->jobPost->userProfile->title)));
            // $this->body = 'The invoice has been sent. Once they pay the deposit, the booking will be confirmed.';
        } elseif ($this->jobQuote->status === 2) { //Request Changes
            $notification = (new NotificationContent)->getEmailContent('Job Quote Response - request changes', 'vendor');
            $notification->subject = str_replace('[couple_title]', ucwords(strtolower(isset($this->jobPost->userProfile->title) ? $this->jobPost->userProfile->title : '')), $notification->subject);

            // $this->title = sprintf('%s has requested to change your quote', ucwords(strtolower($this->jobPost->userProfile->title)));
            // $this->body = 'Review their change requests';
        } elseif ($this->jobQuote->status === 4) { //Declined
            $notification = (new NotificationContent)->getEmailContent('Job Quote Response - declined', 'vendor');
            $notification->subject = str_replace('[couple_title]', ucwords(strtolower(isset($this->jobPost->userProfile->title) ? $this->jobPost->userProfile->title : '')), $notification->subject);
            $notification->body = str_replace('[couple_title]', ucwords(strtolower(isset($this->jobPost->userProfile->title) ? $this->jobPost->userProfile->title : '')), $notification->body);
            $notification->body = str_replace('[category_name]', ucwords(strtolower(isset($this->jobPost->category->name) ? $this->jobPost->category->name : '')), $notification->body);
        }

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
        return [
            'title' => $this->title,
            'body' => $this->body,
            'avatar' => $this->jobPost->userProfile->profile_avatar,
            'jobQuoteId' => $this->jobQuote->id,
            'jobPostId' => $this->jobPost->id,
            'jobPostUserId' => $this->jobPost->user_id,
            'status' => $this->jobQuote->status,
        ];
    }

    public function setData()
    {
        $this->title = $this->body = '';
        if ($this->jobQuote->status === 3) { //Accepted
            $dashboard_notifications = (new NotificationContent)->getNotificationContent('Job Quote Response - accepted', 'vendor');
            foreach ($dashboard_notifications as $dashboard_notification) {
                $this->title = $dashboard_notification->subject = str_replace('[couple_title]', ucwords(strtolower(isset($this->jobPost->userProfile->title) ? $this->jobPost->userProfile->title : '')), $dashboard_notification->subject);
                $this->body = $dashboard_notification->body;
            }
        } elseif ($this->jobQuote->status === 2) { //Request Changes
            $dashboard_notifications = (new NotificationContent)->getNotificationContent('Job Quote Response - request changes', 'vendor');
            foreach ($dashboard_notifications as $dashboard_notification) {
                $this->title = $dashboard_notification->subject = str_replace('[couple_title]', ucwords(strtolower(isset($this->jobPost->userProfile->title) ? $this->jobPost->userProfile->title : '')), $dashboard_notification->subject);
                $this->body = $dashboard_notification->body;
            }
        } elseif ($this->jobQuote->status === 4) { //Declined
            $dashboard_notifications = (new NotificationContent)->getNotificationContent('Job Quote Response - declined', 'vendor');
            foreach ($dashboard_notifications as $dashboard_notification) {
                $this->title = $dashboard_notification->subject = str_replace('[couple_title]', ucwords(strtolower(isset($this->jobPost->userProfile->title) ? $this->jobPost->userProfile->title : '')), $dashboard_notification->subject);
                $this->body = $dashboard_notification->body = str_replace('[couple_title]', ucwords(strtolower(isset($this->jobPost->userProfile->title) ? $this->jobPost->userProfile->title : '')), $dashboard_notification->body);
                $this->body = $dashboard_notification->body = str_replace('[category_name]', ucwords(strtolower(isset($this->jobPost->category->name) ? $this->jobPost->category->name : '')), $dashboard_notification->body);
            }
        }

        // if ($this->jobQuote->status === 3) {
        //     $this->title = sprintf('%s have accepted your quote', ucwords(strtolower($this->jobPost->userProfile->title)));
        //     $this->body = 'The invoice has been sent. Once they pay the deposit, the booking will be confirmed.';
        // } elseif ($this->jobQuote->status === 2) {
        //     $this->title = sprintf('%s has requested to change your quote', ucwords(strtolower($this->jobPost->userProfile->title)));
        //     $this->body = 'Review their change requests';
        // } elseif ($this->jobQuote->status === 4) {
        //     $this->title = sprintf('Your quote has been declined by %s', ucwords(strtolower($this->jobPost->userProfile->title)));
        //     $this->body = sprintf(
        //         'Your quote for "%s looking for %s" was declined',
        //          $this->jobPost->userProfile->title,
        //         $this->jobPost->category->name
        //     );
        // }

        return $this;
    }
}
