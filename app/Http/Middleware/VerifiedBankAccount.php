<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifiedBankAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            abort(403);
        }

        if ($user->account !== 'vendor') {
            return $next($request);
        }

        $paymentSetting = $user->vendorProfile->paymentSetting;

        if (!$paymentSetting || !$paymentSetting->status || $paymentSetting->status === 0) {
            // abort(403, 'payment-settings-not-set');
        }

        return $next($request);
    }
}
