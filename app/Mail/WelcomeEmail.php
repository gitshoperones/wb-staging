<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Couple;
use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $notification;
    public $profile;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $notification)
    {
        $this->user = $user;
        $this->notification = $notification;

        if ($user->account === 'vendor') {
            $this->profile = Vendor::where('user_id', $user->id)->first(['id']);
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $notification = $this->notification;
        $notification->button_link = ($this->user->account === 'vendor') ? sprintf('vendors/%s', $this->profile->id) : $notification->button_link;

        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($this->notification->subject)
            ->view('emails.email-notification-main-template', compact('notification'));
    }
}
