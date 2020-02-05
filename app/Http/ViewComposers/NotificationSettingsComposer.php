<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationSettingsComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        $notificationSetting = $user->notificationSettings()->where('meta_key', 'all')->first();
        $emails = $user->emails->pluck('email');
        $view->with(compact('notificationSetting', 'emails'));
    }
}
