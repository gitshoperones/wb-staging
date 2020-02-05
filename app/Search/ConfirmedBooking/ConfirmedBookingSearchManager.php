<?php

namespace App\Search\ConfirmedBooking;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class ConfirmedBookingSearchManager
{
    public static function applyFilters(array $filters, $relationshipsToEagerload = [])
    {
        $query = Invoice::whereIn('status', [1, 2]);

        if (Auth::user()->account === 'couple') {
            $coupleId = Auth::user()->coupleProfile()->id;

            $query = Invoice::where('couple_id', $coupleId)->whereIn('status', [1, 2]);
        }

        if (Auth::user()->account === 'vendor') {
            $query = Invoice::where('vendor_id', Auth::user()->vendorProfile->id)->whereIn('status', [1, 2]);
        }

        return $query->whereHas('jobQuote', function ($query) use ($filters) {
            $query->whereHas('jobPost', function ($query) use ($filters) {
                return static::applyFiltersToQuery($filters, $query);
            });
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

    public static function keywordSearch($filter = null, $relationshipsToEagerload = [])
    {
        $query = Invoice::whereIn('status', [0, 1, 2]);
        
        if ($query->count()) {
            $query->whereHas('jobQuote', function ($q) use ($filter) {
                $q->whereHas('jobPost', function ($q) use ($filter) {
                    $q->whereHas('category', function ($q) use ($filter) {
                        $q->where('name', 'like', '%'.$filter.'%');
                    })
                    ->orWhereHas('locations', function ($q) use ($filter) {
                        $q->where('name', 'like', '%'.$filter.'%');
                    })
                    ->orWhereHas('event', function ($q) use ($filter) {
                        $q->where('name', 'like', '%'.$filter.'%');
                    })
                    ->orWhere(function ($q) use ($filter) {
                        if (strtotime($filter)) {
                            $q->whereDate('event_date', Carbon::parse($filter)->toDateString());
                        }
                    });
                });
            })->orWhereHas('couple', function ($q) use ($filter) {
                $q->where('title', 'like', "%{$filter}%");
            });
        }
        
        return $query->with($relationshipsToEagerload)->orderBy('created_at', 'DESC')->paginate(20);
    }
}
