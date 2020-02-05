<?php

namespace App\Search\Vendor\Filters;

use App\Models\Location;
use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class States implements Search
{
    public static function apply(Builder $builder, $value)
    {
        $locationIds = Location::whereIn('state', $value)->orWhereIn('name', $value)->orWhere('name', 'Australia Wide')->pluck('id');

        return $builder->whereHas('locations', function ($q) use ($locationIds) {
            $q->whereIn('locations.id', $locationIds);
        });
    }
}
