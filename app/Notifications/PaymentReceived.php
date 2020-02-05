<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Invoice;
use App\Models\JobPost;
use Illuminate\Bus\Queueable;
use App\Models\NotificationSetting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public $body;
    public $title;
    public $user;
    public $jobQuote;
    public $jobPost;
    public $invoice;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, User $user)
    {
        $this->user = $user;
        $this->invoice = $invoice;
        $this->jobQuote = $invoice->jobQuote;
        $this->jobPost = JobPost::whereId($invoice->jobQuote->job_post_id)
            ->with('userProfile')->first(['id', 'user_id', 'category_id']);

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
        return (new MailMessage)
            ->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($this->title)
            ->view('emails.account-notification-summary', [
                'body' => $this->body,
            ]);
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
            'invoiceId' => $this->invoice->id,
        ];
    }

    public function setData()
    {
        $this->title = 'Your booking is confirmed';
        $this->body = sprintf(
            '%s made payment and this booking is now confirmed.',
            ucwords(strtolower($this->jobPost->userProfile->title))
        );

        return $this;
    }
}
