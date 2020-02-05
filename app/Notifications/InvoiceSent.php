<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Invoice;
use App\Models\JobPost;
use App\Models\JobQuote;
use Illuminate\Bus\Queueable;
use App\Models\NotificationSetting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\AccountNotificationSummary;
use Illuminate\Notifications\Messages\MailMessage;
use App\Helpers\NotificationContent;

class InvoiceSent extends Notification implements ShouldQueue
{
    use Queueable;

    public $invoice;
    public $jobQuote;
    public $jobPost;
    public $user;
    public $body;
    public $title;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, User $user, $type)
    {
        $this->user = $user;
        $this->invoice = $invoice;
        $this->jobQuote = JobQuote::whereId($invoice->job_quote_id)->first();
        $this->jobPost = JobPost::whereId($this->jobQuote->job_post_id)
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
        $notification = (new NotificationContent)->getEmailContent('Invoice Sent', 'vendor');
        $notification->body = str_replace('[profile_title]', ucwords(strtolower(isset($this->jobPost->userProfile->title) ? $this->jobPost->userProfile->title : '')), $notification->body);

        return (new MailMessage)
            ->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject(ucfirst(strtolower($notification->subject)))
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
            'invoiceId' => $this->invoice->id,
            'jobQuoteId' => $this->jobQuote->id,
            'jobPostId' => $this->jobPost->id
        ]; // dashboard - notif
    }

    public function setData()
    {
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Invoice Sent', 'vendor');
        foreach ($dashboard_notifications as $dashboard_notification) {
            $this->title = $dashboard_notification->subject;
            $this->body = $dashboard_notification->body = str_replace('[profile_title]', ucwords(strtolower(isset($this->jobPost->userProfile->title) ? $this->jobPost->userProfile->title : '')), $dashboard_notification->body);
        }
    }
}
