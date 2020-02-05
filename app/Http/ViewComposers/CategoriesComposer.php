<?php

namespace App\Http\ViewComposers;

use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class CategoriesComposer
{
    public function compose(View $view)
    {
        $categories = Cache::rememberForever('categories', function () {
            return Category::orderBy('order')->get(['id', 'name', 'template']);
        });

        $view->with('categories', $categories);
    }
}
