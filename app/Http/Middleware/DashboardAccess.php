<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Fee;
use App\Helpers\MarkNotification;
use Illuminate\Support\Facades\Auth;

class DashboardAccess
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

        if (
            !$user
            || $user->status === 'pending email verification'
            || $user->status === 'rejected'
            || $user->status === 'archived'
        ) {
            abort(403, 'Your account is inactive. Contact hello@wedbooker.com for more information.');
        }

        $fee = Fee::where('type', 'default')->where('status', 1)->first();

        if (!$fee) {
            abort(403, 'Platform default fee is not set. Contact hello@wedbooker.com for more information.');
        }

        if ($user->account === 'vendor') {
            $vendor = $user->vendorProfile;
            if (!$vendor->onboarding) {
                return redirect(sprintf('/vendors/%s', $vendor->id));
            }
        }

        // mark notification as read
        if ($request->notificationId) {
            (new MarkNotification)->asRead($user, $request->notificationId);
        }

        return $next($request);
    }
}
