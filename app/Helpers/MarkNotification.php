<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class MarkNotification
{
    public function asRead(User $user, $notificationId = null)
    {
        if (!$notificationId) {
            return false;
        }

        $user->unreadNotifications
            ->where('id', $notificationId)
            ->markAsRead();

        Cache::forget(sprintf('cached-notificationsCount-%s', $user->id));
    }
}
