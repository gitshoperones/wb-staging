<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\PropertyFeature;
use Illuminate\Support\Facades\Cache;

class PropertyFeaturesComposer
{
    public function compose(View $view)
    {
        $propertyFeatures = Cache::rememberForever('cached-propertyFeatures', function () {
            return PropertyFeature::orderBy('name')->get(['id', 'name']);
        });

        $view->with('propertyFeatures', $propertyFeatures);
    }
}
