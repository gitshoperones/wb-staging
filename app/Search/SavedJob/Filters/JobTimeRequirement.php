<?php

namespace App\Search\SavedJob\Filters;

use App\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class JobTimeRequirement implements Search
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('job_time_requirement_id', $value);
    }
}
