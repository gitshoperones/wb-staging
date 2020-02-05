<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\AdminEmailNotification;

class RefundRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $invoice;
    public $param;
    public $notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, array $param, $notification)
    {
        $this->invoice = $invoice;
        $this->param = $param;
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

        $notification->body = str_replace('[business_name]', isset($this->invoice->vendor->business_name) ? $this->invoice->vendor->business_name : '', $notification->body);
        $notification->body = str_replace('[couple_title]', isset($this->invoice->couple->title) ? $this->invoice->couple->title : '', $notification->body);
        $notification->body = str_replace('[amount]', isset($this->param['amount']) ? number_format(floatval($this->param['amount']), 2) : '', $notification->body);
        $notification->body = str_replace('[reason]', isset($this->param['reason']) ? $this->param['reason'] : '', $notification->body);
        $notification->body = str_replace('[cancel_booking]', isset($this->param['cancel_booking']) ? $this->param['cancel_booking'] : '', $notification->body);
        $notification->body = str_replace('[category_name]', isset($this->invoice->jobQuote->jobPost->category->name) ? $this->invoice->jobQuote->jobPost->category->name : '', $notification->body);
        $notification->body = str_replace('[location]', $this->invoice->jobQuote->jobPost->locations->implode('name', ',&nbsp;'), $notification->body);
        
        $notification->body = str_replace('[event_name]', $this->invoice->jobQuote->jobPost->event->name, $notification->body);
        
        $notification->body = str_replace('[event_date]', $this->invoice->jobQuote->jobPost->event_date ?: 'unknown', $notification->body);

        $notification->body = str_replace('[budget]', $this->invoice->jobQuote->jobPost->budget, $notification->body);
        
        $notification->body = str_replace('[number_of_guests]', $this->invoice->jobQuote->jobPost->number_of_guests, $notification->body);

        $propertyTypes = '';
        foreach($this->invoice->jobQuote->jobPost->propertyTypes as $item){
            $propertyTypes .= "<li>{$item->name}</li>";
        }
        $notification->body = str_replace('[property_types]', $propertyTypes, $notification->body);

        $notification->body = str_replace('[looking_for]', $this->invoice->jobQuote->jobPost->beautySubcategory->name ?: '', $notification->body);

        $websiteRequirements = '';
        foreach($this->invoice->jobQuote->jobPost->websiteRequirements as $item){
            $websiteRequirements .= "<li>{$item->name}</li>";
        }
        $notification->body = str_replace('[website_requirements]', $websiteRequirements, $notification->body);

        $notification->body = str_replace('[completion_date]', $this->invoice->jobQuote->jobPost->completion_date, $notification->body);

        $otherRequirements = '';
        foreach($this->invoice->jobQuote->jobPost->propertyFeatures as $item){
            $otherRequirements .= "<li>{$item->name}</li>";
        }
        $notification->body = str_replace('[other_requirements]', $otherRequirements, $notification->body);

        $notification->body = str_replace('[time_required]',  optional($this->invoice->jobQuote->jobPost->timeRequirement)->name, $notification->body);

        $notification->body = str_replace('[venue_or_address]',  $this->invoice->jobQuote->jobPost->required_address, $notification->body);

        $notification->body = str_replace('[street]',  $this->invoice->jobQuote->jobPost->shipping_address['street'], $notification->body);
        $notification->body = str_replace('[suburb]',  $this->invoice->jobQuote->jobPost->shipping_address['suburb'], $notification->body);
        $notification->body = str_replace('[state]',  $this->invoice->jobQuote->jobPost->shipping_address['state'], $notification->body);
        $notification->body = str_replace('[post_code]',  $this->invoice->jobQuote->jobPost->shipping_address['post_code'], $notification->body);

        $notification->body = str_replace('[job_specification]',  $this->invoice->jobQuote->jobPost->specifics, $notification->body);

        AdminEmailNotification::create([
            'notification_event_id' => $notification->notification_event_id,
            'subject' => $notification->subject,
            'body' => $notification->body,
        ]);
        
        return $this->from(config('mail.from.address'), 'The wedBooker Team')
            ->subject($notification->subject)
            ->view('emails.email-notification-admin-template', compact('notification'));
    }
}
