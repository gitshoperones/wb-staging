<?php

namespace App\Search\FavoriteVendor;

use App\Models\Vendor;
use App\Models\FavoriteVendor;
use Illuminate\Support\Facades\Auth;

class FavoriteVendorSearchManager
{
    public static function applyFilters(array $filters, $relationshipsToEagerload = [])
    {
        return FavoriteVendor::where('user_id', $filters['user_id'] ?? Auth::id())
            ->whereHas('vendorProfile', function ($q) use($filters) {
                return static::applyFiltersToQuery($filters, $q);
            })
            ->with($relationshipsToEagerload)->orderBy('created_at', 'DESC');
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
