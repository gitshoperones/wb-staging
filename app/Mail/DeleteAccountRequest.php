<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\AdminEmailNotification;

class DeleteAccountRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $data;
    public $notification;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, array $data, $notification)
    {
        $this->user = $user;
        $this->data = $data;
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
        $notification->body = str_replace('[reason]', ucwords(strtolower(isset($this->data['reason']) ? $this->data['reason'] : '')), $notification->body);
        $notification->body = str_replace('[details]', ucwords(strtolower(isset($this->data['details']) ? $this->data['details'] : '')), $notification->body);
        $notification->body = str_replace('[user_type]', ucwords(strtolower($this->user->account)), $notification->body);

        $name = '';
        if ($this->user->account === 'vendor') {
            $vendor = Vendor::where('user_id', $this->user->id)->first(['id', 'business_name']);
            $name = $vendor->business_name;
        }
        if ($this->user->account === 'couple') {
            $name = sprintf('%s %s', $this->user->fname, $this->user->lname);
        }

        $notification->body = str_replace('[name]', ucwords(strtolower(($name != '') ? $name : '')), $notification->body);

        AdminEmailNotification::create([
            'notification_event_id' => $notification->notification_event_id,
            'subject' => $notification->subject,
            'body' => $notification->body,
            'user_id' => $this->user->id
        ]);

        return $this->from($this->user->email, $name)
            ->subject($notification->subject)
            ->view('emails.email-notification-admin-template', compact('notification'));
    }
}
