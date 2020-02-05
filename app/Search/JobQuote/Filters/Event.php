<?php

namespace App\Search\JobQuote\Filters;

use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class Event implements Search
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('event_id', $value);
    }
}
