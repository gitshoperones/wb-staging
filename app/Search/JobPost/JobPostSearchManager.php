<?php

namespace App\Search\JobPost;

use App\Models\Couple;
use App\Models\JobPost;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class JobPostSearchManager
{
    public static function applyFilters(array $filters, $relationshipsToEagerload = [])
    {
        $query = with(new JobPost)->newQuery()
            ->with($relationshipsToEagerload)->orderBy('created_at', 'DESC');

        return static::applyFiltersToQuery($filters, $query);
    }

    public static function applyFiltersToQuery($filters, $query)
    {
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
                $query = $className::apply($query, $value);
            }
        }

        return $query;
    }

    public static function keywordSearch($filter = null, $isTrash = false)
    {
        if (!$isTrash)
            $query = JobPost::whereStatus(1);
        elseif($isTrash == 2)
            $query = JobPost::whereStatus(2);
        elseif($isTrash == 3)
            $query = JobPost::whereStatus(5);
        else
            $query = JobPost::onlyTrashed();

        if (Auth::user()->account === 'couple') {
            $couple = Couple::where('userA_id', Auth::user()->id)
                ->orWhere('userB_id', Auth::user()->id)
                ->first(['id', 'userA_id']);
            $query->where('user_id', $couple->userA_id);
        }

        if ($filter) {
            $query->where(function ($q) use ($filter) {
                $q->whereHas('category', function ($q) use ($filter) {
                    $q->where('name', 'like', '%'.$filter.'%');
                })
                ->orWhereHas('locations', function ($q) use ($filter) {
                    $q->where('name', 'like', '%'.$filter.'%');
                })
                ->orWhereHas('event', function ($q) use ($filter) {
                    $q->where('name', 'like', '%'.$filter.'%');
                })
                ->orWhereHas('userProfile', function ($q) use ($filter) {
                    $q->where('title', 'like', "%{$filter}%");
                })
                ->orWhere(function ($q) use ($filter) {
                    if (strtotime($filter)) {
                        $q->whereDate('event_date', Carbon::parse($filter)->toDateString());
                    }
                });
            });
        }
        
        return $query->with(['userProfile', 'category', 'event', 'locations', 'quotes' => function ($q) {
            $q->addSelect(['id', 'job_post_id']);
        }])->orderBy('created_at', 'DESC')->paginate(20);
    }
}
