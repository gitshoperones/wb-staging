<?php

namespace App\Search\FavoriteVendor\Filters;

use App\Models\PropertyType;
use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class PropertyTypes implements Search
{
    public static function apply(Builder $builder, $value)
    {
        $typeIds = PropertyType::whereIn('name', $value)->pluck('id');

        return $builder->whereHas('propertyTypes', function ($q) use ($typeIds) {
            $q->whereIn('property_types.id', $typeIds);
        });
    }
}
