<?php

namespace App\Search\SavedJob\Filters;

use App\Contracts\Search;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

class EventDateFrom implements Search
{
    public static function apply(Builder $builder, $value)
    {
        $value = Carbon::parse($value)->toDateString();

        return $builder->whereDate('event_date', '>=', $value);
    }
}
