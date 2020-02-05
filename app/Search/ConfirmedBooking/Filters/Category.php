<?php

namespace App\Search\ConfirmedBooking\Filters;

use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class Category implements Search
{
    public static function apply(Builder $builder, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        return $builder->whereHas('category', function ($q) use ($value) {
            $q->whereIn('name', $value);
        });
    }
}
