<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AddVendorReview extends Notification
{
    use Queueable;

    public $data;
    public $notification;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->data['title'] = str_replace('[vendor_title]', ucwords(strtolower(isset($this->vendorTitle) ? $this->vendorTitle : '')), $this->data['title']);
        $this->data['body'] = str_replace('[couple_title]', ucwords(strtolower(isset($this->coupleTitle) ? $this->coupleTitle : '')), $this->data['body']);
        $this->data['body'] = str_replace('[vendor_title]', ucwords(strtolower(isset($this->vendorTitle) ? $this->vendorTitle : '')), $this->data['body']);
        $this->data['btnTxt'] = str_replace('[vendor_title]', ucwords(strtolower(isset($this->vendorTitle) ? $this->vendorTitle : '')), $this->data['btnTxt']);
        $this->data['btnLink'] = sprintf('/vendor-review/%s?job-quote-id=%s', $this->data['code'], $this->data['jobQuoteId']);
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
        return $this->data;
    }
}
