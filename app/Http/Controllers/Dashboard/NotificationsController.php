<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->where('type', '<>', 'Musonza\\Chat\\Notifications\\MessageSent')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        Cache::forget(sprintf('cached-notificationsCount-%s', $user->id));

        return view('notifications.index', compact('notifications'));
    }

    public function update($notificationId)
    {
        Auth::user()->notifications()->whereId($notificationId)->firstOrFail()->markAsRead();

        return response()->json();
    }

    public function markAll()
    {
        $user = Auth::user();
        $user->notifications->markAsRead();
        
        Cache::forget(sprintf('cached-notificationsCount-%s', $user->id));

        return redirect()->back();
    }
}
