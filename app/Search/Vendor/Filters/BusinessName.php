<?php

namespace App\Search\Vendor\Filters;

use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class BusinessName implements Search
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('business_name', 'like', '%'.$value.'%');
    }
}
