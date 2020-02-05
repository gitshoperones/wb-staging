<?php

namespace App\Search\SavedJob\Filters;

use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class NumberOfGuests implements Search
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('number_of_guests', $value);
    }
}
