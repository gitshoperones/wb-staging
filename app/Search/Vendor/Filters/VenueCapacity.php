<?php

namespace App\Search\Vendor\Filters;

use App\Models\PropertyType;
use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class VenueCapacity implements Search
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->whereHas('venueCapacity', function ($q) use ($value) {
            $q->where('capacity', '>=', (int) $value);
        });
    }
}
