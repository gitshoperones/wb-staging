<?php

namespace App\Search\SavedJob\Filters;

use App\Contracts\Search;
use App\Models\Category as CategoryModel;
use Illuminate\Database\Eloquent\Builder;

class Category implements Search
{
    public static function apply(Builder $builder, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $catIds = CategoryModel::where(function ($q) use ($value) {
            foreach ($value as $item) {
                $q->orwhere('name', 'like', '%'.$item.'%');
            }
        })->pluck('id');

        return $builder->whereIn('category_id', $catIds);
    }
}
