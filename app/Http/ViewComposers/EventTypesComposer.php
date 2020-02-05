<?php

namespace App\Http\ViewComposers;

use App\Models\Event;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class EventTypesComposer
{
    public function compose(View $view)
    {
        $eventTypes = Cache::rememberForever('eventTypes', function () {
            return Event::all(['id', 'name']);
        });

        $view->with('eventTypes', $eventTypes);
    }
}
