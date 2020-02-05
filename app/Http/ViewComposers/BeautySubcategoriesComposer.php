<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\BeautySubcategory;
use Illuminate\Support\Facades\Cache;

class BeautySubcategoriesComposer
{
    public function compose(View $view)
    {
        $beautySubcategories = Cache::rememberForever('beautySubcategories', function () {
            return BeautySubcategory::orderBy('name')->get(['id', 'name']);
        });

        $view->with('beautySubcategories', $beautySubcategories);
    }
}
