<?php

namespace App\Search\FavoriteVendor\Filters;

use App\Models\PropertyFeature;
use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class PropertyFeatures implements Search
{
    public static function apply(Builder $builder, $value)
    {
        $featurIds = PropertyFeature::whereIn('name', $value)->pluck('id');

        return $builder->whereHas('propertyFeatures', function ($q) use ($featurIds) {
            $q->whereIn('property_features.id', $featurIds);
        });
    }
}
