<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\AdminEmailNotification;

class ContactUs extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $requestData;
    public $notification;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $requestData, $notification)
    {
        $this->requestData = $requestData;
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
        $notification->subject = str_replace('[reason]', ucwords(strtolower(isset($this->requestData['reason']) ? $this->requestData['reason'] : '')), $notification->subject);
        $notification->body = str_replace('[name]', ucwords(strtolower(isset($this->requestData['name']) ? $this->requestData['name'] : '')), $notification->body);
        $notification->body = str_replace('[email]', ucwords(strtolower(isset($this->requestData['email']) ? $this->requestData['email'] : '')), $notification->body);
        $notification->body = str_replace('[reason]', ucwords(strtolower(isset($this->requestData['reason']) ? $this->requestData['reason'] : '')), $notification->body);
        $notification->body = str_replace('[source]', ucwords(strtolower(isset($this->requestData['source']) ? $this->requestData['source'] : '')), $notification->body);
        $notification->body = str_replace('[phone]', ucwords(strtolower(isset($this->requestData['phone']) ? $this->requestData['phone'] : '')), $notification->body);
        $notification->body = str_replace('[message]', ucwords($this->requestData['message']), $notification->body);
        
        AdminEmailNotification::create([
            'notification_event_id' => $notification->notification_event_id,
            'subject' => $notification->subject,
            'body' => $notification->body,
        ]);
        
        return $this->from($this->requestData['email'], $this->requestData['name'])
            ->subject(ucfirst($notification->subject))
            ->view('emails.email-notification-admin-template', compact('notification'));
    }
}
