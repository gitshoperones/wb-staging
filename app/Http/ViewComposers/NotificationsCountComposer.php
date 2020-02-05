<?php

namespace App\Http\ViewComposers;

use App\Models\User;
use App\Models\Couple;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class NotificationsCountComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        $notificationsCount = 0;

        if ($user) {
            $notificationsCount = Cache::rememberForever(
                sprintf('cached-notificationsCount-%s', $user->id),
                function () use ($user) {
                    return $this->getUserNotificationsCount($user);
                }
            );
        }

        $view->with('notificationsCount', $notificationsCount);
    }

    private function getUserNotificationsCount(User $user)
    {
        if ($user === 'couple') {
            $couple = Couple::where('userA_id', $user->id)
                ->orWhere('userB_id', $user->id)
                ->first(['id', 'userA_id']);
            return User::whereId($couple->userA_id)->first(['id'])
                ->unreadNotifications()
                ->where('type', '<>', 'Musonza\\Chat\\Notifications\\MessageSent')
                ->count();
        }

        return $user->unreadNotifications()
            ->where('type', '<>', 'Musonza\\Chat\\Notifications\\MessageSent')
            ->count();
    }
}
