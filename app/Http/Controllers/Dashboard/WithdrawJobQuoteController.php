<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\JobQuote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\JobQuoteWithdrawn;

class WithdrawJobQuoteController extends Controller
{
    public function update($jobQuoteId, Request $request)
    {
        $jobQuote = JobQuote::whereId($jobQuoteId)->where('user_id', Auth::id())
            ->with([
                'jobPost.user.coupleA',
                'user.vendorProfile'
            ])->firstOrFail();

        if (Gate::denies('edit-job-quote', $jobQuote)) {
            abort(403);
        }

        $jobQuote->fill(['status' => 6])->save();
        $vendorUser = $jobQuote->user;
        $coupleUser = $jobQuote->jobPost->user;

        $coupleUser->notify(new JobQuoteWithdrawn($coupleUser, $jobQuote));
        $vendorUser->notify(new JobQuoteWithdrawn($vendorUser, $jobQuote));

        return redirect()->back()->with('success_message', 'You quote was successfully withdrawn!');
    }
}
