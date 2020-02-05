<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class UnreadNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $notification)
    {
        $this->user = $user;
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
        $dear = null;
        if ($this->user->account == 'vendor') {
            $dear = ($this->user->vendorProfile->business_name) ? $this->user->vendorProfile->business_name : 'Business Owner';
        } elseif ($this->user->account == 'couple') {
            $dear = ($this->user->coupleProfile()->title) ? $this->user->coupleProfile()->title : 'Couples';
        }

        $notification->body = str_replace('[send_to]', ucwords(strtolower($dear)), $notification->body);

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject(ucfirst($notification->subject))
            ->view('emails.email-notification-main-template', compact('notification'));
    }
}
