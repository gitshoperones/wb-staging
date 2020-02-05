<?php

namespace App\Search\Vendor\Filters;

use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class PropertyCapacity implements Search
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->whereHas('venueCapacity', function ($q) use ($value) {
            $q->where('capacity', $value);
        });
    }
}
