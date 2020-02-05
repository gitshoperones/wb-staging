<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\WebsiteRequirement;
use Illuminate\Support\Facades\Cache;

class WebsiteRequirementsComposer
{
    public function compose(View $view)
    {
        $websiteRequirements = Cache::rememberForever('cached-websiteRequirements', function () {
            return WebsiteRequirement::orderBy('name')->get(['id', 'name']);
        });

        $view->with('websiteRequirements', $websiteRequirements);
    }
}
