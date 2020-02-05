<?php

namespace App\Search\JobPost\Filters;

use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class Budget implements Search
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('budget', $value);
    }
}
