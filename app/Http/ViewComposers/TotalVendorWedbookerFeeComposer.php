<?php

namespace App\Http\ViewComposers;

use App\Models\Fee;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class TotalVendorWedbookerFeeComposer
{
    public function compose(View $view)
    {
        $feeId = optional(Auth::user()->vendorProfile->fee()->first())->fee_id;
        $feePercent = $feeId ? Fee::whereId($feeId)->first()->amount : Fee::where('type', 'default')->first()->amount ;

        $view->with('totalWedbookerFee', $feePercent);
    }
}
