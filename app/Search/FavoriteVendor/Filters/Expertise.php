<?php

namespace App\Search\FavoriteVendor\Filters;

use App\Contracts\Search;
use App\Models\Category as CategoryModel;
use Illuminate\Database\Eloquent\Builder;

class Expertise implements Search
{
    public static function apply(Builder $builder, $value)
    {
        $expertiseIds = CategoryModel::whereIn('name', $value)->pluck('id');

        return $builder->whereHas('expertise', function ($q) use ($expertiseIds) {
            $q->whereIn('categories.id', $expertiseIds);
        });
    }
}
