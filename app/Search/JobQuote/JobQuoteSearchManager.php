<?php

namespace App\Search\JobQuote;

use App\Models\JobPost;
use App\Models\JobQuote;
use Illuminate\Support\Facades\Auth;

class JobQuoteSearchManager
{
    public static function applyFilters(array $filters, $relationshipsToEagerload = [])
    {
        $query = with(new JobQuote)->newQuery();

        if (!isset($filters['status'])) {
            $query = JobQuote::where('status', '<>', 0);
        } else {
            $query = JobQuote::where('status', $filters['status']);
        }

        if (Auth::user()->account === 'couple') {
            $jobPostIds = JobPost::where('user_id', Auth::user()->id)
                ->get(['id', 'user_id'])->pluck('id')->toArray();
            $query = $query->whereIn('job_post_id', $jobPostIds);
        } else {
            $query = $query->where('user_id', Auth::id());
        }

        return $query->whereHas('jobPost', function ($query) use ($filters) {
            return static::applyFiltersToQuery($filters, $query);
        })->with($relationshipsToEagerload)->orderBy('created_at', 'DESC');
    }

    public static function applyFiltersToQuery($filters, $query)
    {
        $q = $query;

        foreach ($filters as $key => $value) {
            if (is_array($value) && count($value) <= 0) {
                continue;
            } elseif ($value === '' || $value === null) {
                continue;
            }

            $className = str_replace('_', ' ', $key);
            $className = ucwords($className);
            $className = str_replace(' ', '', $className);

            $className = sprintf(
                '%s\\Filters\\%s',
                __namespace__,
                $className
            );

            if (class_exists($className)) {
                $q = $className::apply($query, $value);
            }
        }

        return $q;
    }
}
