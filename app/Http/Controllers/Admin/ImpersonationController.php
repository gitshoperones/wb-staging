<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function impersonate($id)
    {
        $user = Auth::user();
        $userToImpersonate = User::whereId($id)->firstOrFail();

        if (!in_array($user->account, ['admin', 'parent'])) {
            abort(403, 'Sorry, you are not authorized to perform this action.');
        }

        if ($user->account === 'parent') {
            if ($userToImpersonate->account !== 'vendor') {
                abort(403, 'Sorry, you are not authorized to perform this action.');
            }

            $childAccounts = $user->vendorProfile->childVendors()->pluck('child_vendor_id')->toArray();

            if (!in_array($userToImpersonate->vendorProfile->id, $childAccounts)) {
                abort(403, 'Sorry, you are not authorized to perform this action.');
            }
        }

        if ($user->account === 'admin') {
            session(['wedbookerImpersonatePreviousURL' => URL::previous()]);
        } else {
            session(['parentImpersonation' => true]);
        }

        $user->impersonate($userToImpersonate);

        return redirect(request('url') ?: '/dashboard');
    }

    public function leave()
    {
        Auth::user()->leaveImpersonation();
        $redirectTo = session('wedbookerImpersonatePreviousURL') ?: '/dashboard';

        session()->forget('parentImpersonation');
        session()->forget('wedbookerImpersonatePreviousURL');

        return redirect($redirectTo);
    }
}
