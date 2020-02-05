<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\JobTimeRequirement;
use Illuminate\Support\Facades\Cache;

class JobTimeRequirementsComposer
{
    public function compose(View $view)
    {
        $jobTimeRequirements = Cache::rememberForever('jobTimeRequirements', function () {
            return JobTimeRequirement::all(['id', 'name']);
        });

        $view->with('jobTimeRequirements', $jobTimeRequirements);
    }
}
