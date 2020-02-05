<?php

namespace App\Http\ViewComposers;

use App\Models\Location;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class LocationsComposer
{
    public function compose(View $view)
    {
        $locations = Cache::rememberForever('cached-locations', function () {
            return Location::orderBy('name')->get(['id', 'name', 'abbr']);
        });

        $view->with('locations', $locations);
    }
}
