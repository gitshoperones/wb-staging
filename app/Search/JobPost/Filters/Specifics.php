<?php

namespace App\Search\JobPost\Filters;

use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class Specifics implements Search
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('specifics', 'like', '%'.$value.'%');
    }
}
