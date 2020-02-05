<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Fee;
use App\Helpers\MarkNotification;
use Illuminate\Support\Facades\Auth;

class IsParent
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
        
        if (!$user || $user->account != 'parent') {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
