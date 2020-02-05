<?php

namespace App\Listeners;

use App\Events\CoupleSentPayment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateInvoiceStatus
{
    /**
     * Handle the event.
     *
     * @param  CoupleSentPayment  $event
     * @return void
     */
    public function handle(CoupleSentPayment $event)
    {
        $invoice = $event->payment->invoice;
        $unpaidMilestone = $invoice->jobQuote->milestones()->where('paid', 0)->first();
        $data = [];

        if ($unpaidMilestone) {
            $data['status'] = 1;
            $data['next_payment_date'] = $unpaidMilestone->due_date;
            $balance = $invoice->balance - $event->payment->amount;
            $data['balance'] = $balance <= 0 ? 0 : $balance;
        } else {
            $data['status'] = 2;
            $data['next_payment_date'] = null;
            $data['balance'] = 0.00;
        }


        return $invoice->update($data);
    }
}
