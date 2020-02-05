<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\JobQuote;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class JobQuoteWithdrawn extends Notification
{
    use Queueable;

    public $jobQuote;
    public $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, JobQuote $jobQuote)
    {
        $this->user = $user;
        $this->jobQuote = $jobQuote;
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
        if ($this->user->account === 'vendor') {
            return [
                'title' => sprintf(
                    'You have withdrawn your quote on %s\'s job',
                    $this->jobQuote->jobPost->user->coupleA->title
                ),
                'body' => 'Your quote is now withdrawn. We recommend you message the couple to let them know why',
                'coupleUserId' => $this->jobQuote->jobPost->user->id,
                'vendorUserId' => $this->jobQuote->user->id,
                'btnTxt' => 'Message Couple',
                'jobQuoteId' => $this->jobQuote->id,
            ];
        }

        return [
            'title' => sprintf(
                '%s withdrew their quote',
                $this->jobQuote->user->vendorProfile->business_name
            ),
            'body' => sprintf(
                '%s withdrew their quote on your %s job. You can message them get more information.',
                $this->jobQuote->user->vendorProfile->business_name,
                $this->jobQuote->jobPost->category->name
            ),
            'coupleUserId' => $this->jobQuote->jobPost->user->id,
            'vendorUserId' => $this->jobQuote->user->id,
            'btnTxt' => 'Message Business',
            'jobQuoteId' => $this->jobQuote->id,
        ];
    }
}
