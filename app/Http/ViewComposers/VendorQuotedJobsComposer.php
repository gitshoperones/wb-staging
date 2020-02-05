<?php

namespace App\Http\ViewComposers;

use Chat;
use App\Models\User;
use App\Models\Couple;
use App\Models\JobQuote;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class VendorQuotedJobsComposer
{
    public function compose(View $view)
    {
        $vendorLiveQuotes = JobQuote::where('user_id', Auth::user()->id)
                ->where('status', '<>', 0)
                ->pluck('job_post_id', 'id')->toArray();
        $vendorDraftQuotes = JobQuote::where('user_id', Auth::user()->id)
                ->where('status', 0)
                ->pluck('job_post_id', 'id')->toArray();

        $view->with([
            'vendorLiveQuotes' => $vendorLiveQuotes,
            'vendorDraftQuotes' => $vendorDraftQuotes
        ]);
    }
}
