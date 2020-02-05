<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MessagesCountComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        $messagesCount = 0;

        if ($user) {
            $messagesCount = Cache::rememberForever(
                sprintf('cached-messages-count-%s', $user->id),
                function () use ($user) {
                    return $user->unreadNotifications()
                        ->where('type', 'Musonza\\Chat\\Notifications\\MessageSent')
                        ->count();
                }
            );
        }

        $view->with('messagesCount', $messagesCount);
    }
}
