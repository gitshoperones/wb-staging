<?php

namespace App\Search\JobQuote\Filters;

use App\Models\Location;
use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class Locations implements Search
{
    public static function apply(Builder $builder, $value)
    {
        if (in_array('Australia Wide', $value)) {
            return $builder->whereHas('locations');
        }

        $locations = array_merge(['Australia Wide'], $value);

        $builder->whereHas('locations', function ($q) use ($locations) {
            $q->whereIn('name', $locations);
        });
    }
}
