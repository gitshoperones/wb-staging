<?php

namespace App\Http\ViewComposers;

use App\Models\Couple;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class LoggedInUserProfile
{
    public function compose(View $view)
    {
        $user = Auth::user();
        $loggedInUserProfile = null;

        if ($user) {
            if ($user->account === 'couple') {
                $loggedInUserProfile = Couple::where('userA_id', $user->id)
                    ->orWhere('userB_id', $user->id)->first();
            } else {
                $loggedInUserProfile = $user->vendorProfile()->with([
                    'locations',
                    'expertise'
                ])->first();
            }
        }

        $view->with('loggedInUserProfile', $loggedInUserProfile);
    }
}
