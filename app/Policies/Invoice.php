<?php

namespace App\Policies;

use App\Models\JobPost;

class Invoice
{
    public function pay($user, $invoice)
    {
        if ($user->account !== 'couple') {
            return false;
        }

        return $user->coupleProfile()->id === $invoice->couple_id && $invoice->status !== 2;
    }

    public function show($user, $invoice)
    {
        if ($user->account === 'couple') {
            return $user->coupleProfile()->id === $invoice->couple_id;
        }

        return (int) $user->vendorProfile->id === (int) $invoice->vendor_id;
    }
}
