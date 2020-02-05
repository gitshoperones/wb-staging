<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Cache;

class PropertyTypesComposer
{
    public function compose(View $view)
    {
        $propertyTypes = Cache::rememberForever('cached-propertyTypes', function () {
            return PropertyType::orderBy('name')->get(['id', 'name']);
        });

        $view->with('propertyTypes', $propertyTypes);
    }
}
