<?php

namespace App\Search\Vendor\Filters;

use App\Models\Category;
use App\Models\Location;
use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class Keyword implements Search
{
    public static function apply(Builder $builder, $value)
    {
        $expertise = Category::where('name', 'like', '%'.$value.'%')->pluck('id');
        $locations = Location::where('name', 'like', '%'.$value.'%')->pluck('id');

        if(count($expertise) && count($locations)) {
            return $builder->where('business_name', 'like', '%'.$value.'%')
                            ->orWhereHas('expertise', function ($q) use ($expertise) {
                                $q->whereIn('categories.id', $expertise);
                            })
                            ->whereHas('locations', function ($q) use ($locations) {
                                $q->whereIn('locations.id', $locations);
                            })
                            ->whereHas('user', function ($q) {
                                $q->where('status', '1');
                            });
        }elseif(count($expertise)) {
            return $builder->where('business_name', 'like', '%'.$value.'%')
                            ->orWhereHas('expertise', function ($q) use ($expertise) {
                                $q->whereIn('categories.id', $expertise);
                            })
                            ->whereHas('user', function ($q) {
                                $q->where('status', '1');
                            });
        }elseif(count($locations)) {
            return $builder->where('business_name', 'like', '%'.$value.'%')
                            ->orWhereHas('locations', function ($q) use ($locations) {
                                $q->whereIn('locations.id', $locations);
                            })
                            ->whereHas('user', function ($q) {
                                $q->where('status', '1');
                            });
        }
        
        return $builder->where('business_name', 'like', '%'.$value.'%');

    }
}
