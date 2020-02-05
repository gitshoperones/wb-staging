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

class InvoiceReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;
    public $title;
    public $body;
    public $invoice;
    public $jobQuote;
    public $jobPost;
    public $jobQuoteOwnerProfile;
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
        $this->jobQuoteOwnerProfile = $this->jobQuote->user->vendorProfile;
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
        $notification = (new NotificationContent)->getEmailContent('Invoice Received', 'couple');
        $notification->subject = str_replace('[business_name]', isset($this->jobQuoteOwnerProfile->business_name) ? $this->jobQuoteOwnerProfile->business_name : '', $notification->subject);
        $notification->body = str_replace('[business_name]', isset($this->jobQuoteOwnerProfile->business_name) ? $this->jobQuoteOwnerProfile->business_name : '', $notification->body);

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
            'avatar' => $this->jobQuoteOwnerProfile->profile_avatar,
            'invoiceId' => $this->invoice->id,
            'jobQuoteId' => $this->jobQuote->id,
            'jobPostId' => $this->jobPost->id
        ];
    }

    public function setData()
    {
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Invoice Received', 'couple');
        foreach ($dashboard_notifications as $dashboard_notification) {
            $this->title = $dashboard_notification->subject = str_replace('[business_name]', isset($this->jobQuoteOwnerProfile->business_name) ? $this->jobQuoteOwnerProfile->business_name : '', $dashboard_notification->subject);
            $this->body = $dashboard_notification->body = str_replace('[business_name]', isset($this->jobQuoteOwnerProfile->business_name) ? $this->jobQuoteOwnerProfile->business_name : '', $dashboard_notification->body);
            return $this;
        }

        // $this->title = sprintf('Invoice received from %s', ucwords(strtolower($this->jobQuoteOwnerProfile->business_name)));
        // $this->body = sprintf(
        //     'You\'ve accepted the quote from %s. Pay the deposit to confirm the booking!',
        //     ucwords(strtolower($this->jobQuoteOwnerProfile->business_name))
        // );

        // return $this; // dashboard - notif
    }
}
