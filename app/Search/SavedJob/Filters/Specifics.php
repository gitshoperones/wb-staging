<?php

namespace App\Search\SavedJob\Filters;

use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class Specifics implements Search
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('specifics', 'like', '%'.$value.'%');
    }
}
