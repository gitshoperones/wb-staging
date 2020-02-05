<?php

namespace App\Search\Vendor\Filters;

use App\Models\Category;
use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class Expertise implements Search
{
    public static function apply(Builder $builder, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $expertiseIds = Category::whereIn('name', $value)->pluck('id');

        return $builder->whereHas('expertise', function ($q) use ($expertiseIds) {
            $q->whereIn('categories.id', $expertiseIds);
        });
    }
}
