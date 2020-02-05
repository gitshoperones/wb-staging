<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\AdminEmailNotification;

class NewJobQuote extends Mailable
{
    use Queueable, SerializesModels;

    public $jobQuote;
    public $notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobQuote, $notification)
    {
        $this->jobQuote = $jobQuote;
        $this->notification = $notification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $jobQuote = $this->jobQuote;
        $notification = $this->notification;

        $notification->body = str_replace('[vendor_name]', ucwords(strtolower($jobQuote->user->vendorProfile->business_name)), $notification->body);
        $notification->body = str_replace('[couple_title]', ucwords(strtolower($jobQuote->jobPost->userProfile->title)), $notification->body);
        $notification->body = str_replace('[amount]', ucwords(strtolower($jobQuote->amount)), $notification->body);
        $notification->body = str_replace('[total]', ucwords(strtolower($jobQuote->total)), $notification->body);
        $notification->body = str_replace('[created_at]', ucwords(strtolower($jobQuote->created_at)), $notification->body);
        
        AdminEmailNotification::create([
            'notification_event_id' => $notification->notification_event_id,
            'subject' => $notification->subject,
            'body' => $notification->body,
            'user_id' => $jobQuote->user->id
        ]);

        return $this->subject($this->notification->subject)
            ->view('emails.email-notification-admin-template', compact('notification'));
    }
}
