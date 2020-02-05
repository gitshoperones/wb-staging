<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ParentAccountImpersonationsController extends Controller
{
    public function impersonate($id)
    {
        $user = User::whereId($id)->firstOrFail();
        $loggedInUser = Auth::user();

        if ($loggedInUser->account !== 'parent') {
            abort(403);
        }

        $user->impersonate($user);

        session(['parentImpersonation' => true]);

        return redirect('/dashboard');
    }

    public function leave()
    {
        $user = Auth::user();

        Auth::user()->leaveImpersonation();
        $user2 = Auth::user();
        return [$user, $user2];
        session()->forget('parentImpersonation');

        return redirect('/dashboard');
    }
}
