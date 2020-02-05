<?php

namespace App\Search\SavedJob\Filters;

use App\Models\Location;
use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class Locations implements Search
{
    public static function apply(Builder $builder, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $locIds = Location::where(function ($q) use ($value) {
            foreach ($value as $item) {
                $q->orwhere('name', 'like', '%'.$item.'%');
            }
        })->get(['id'])->pluck('id')->toArray();

        return $builder->whereHas('locations', function ($q) use ($locIds) {
            $q->whereIn('location_id', $locIds);
        });
    }
}
