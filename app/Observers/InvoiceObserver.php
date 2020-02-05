<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Invoice;
use App\Models\JobPost;
use App\Models\JobQuote;
use App\Notifications\InvoiceSent;
use App\Notifications\InvoiceReceived;
use App\Helpers\MultipleEmails;
use Notification;

class InvoiceObserver
{
    public function created(Invoice $invoice)
    {
        $jobQuote = JobQuote::whereId($invoice->job_quote_id)->first(['id', 'user_id', 'job_post_id', 'status']);
        $jobPost = JobPost::whereId($jobQuote->job_post_id)->firstOrFail(['user_id']);
        $jobPostOwner = User::whereId($jobPost->user_id)->firstOrFail(['id', 'account', 'email']);
        $jobQuoteOwner = User::whereId($jobQuote->user_id)->firstOrFail(['id', 'account', 'email']);
        $jobQuote->update(['status' => 5]);
        $postOwnerEmails = ($jobPostOwner->account == "vendor") ? (new MultipleEmails)->getMultipleEmails($jobPostOwner) : $jobPostOwner->email;
        $quoteOwnerEmails = ($jobQuoteOwner->account == "vendor") ? (new MultipleEmails)->getMultipleEmails($jobQuoteOwner) : $jobQuoteOwner->email;

        Notification::route('mail', $postOwnerEmails)->notify(new InvoiceReceived($invoice, $jobPostOwner, 'email'));
        Notification::route('mail', $quoteOwnerEmails)->notify(new InvoiceSent($invoice, $jobQuoteOwner, 'email'));
        $jobPostOwner->notify(new InvoiceReceived($invoice, $jobPostOwner, 'dashboard'));
        $jobQuoteOwner->notify(new InvoiceSent($invoice, $jobQuoteOwner, 'dashboard'));
    }
}
