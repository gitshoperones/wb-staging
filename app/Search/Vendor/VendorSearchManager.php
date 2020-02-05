<?php

namespace App\Search\Vendor;

use App\Models\Vendor;

class VendorSearchManager
{
    public static function applyFilters(array $filters, $relationshipsToEagerload = [])
    {
        $stateId = array_search('states', $relationshipsToEagerload);
        unset($relationshipsToEagerload[$stateId]);

        $query = with(new Vendor)->newQuery()
            ->whereHas('user', function ($q) {
                $q->where('status', 1)->where('account', 'vendor');
            })
            ->with($relationshipsToEagerload)->orderByRaw('ISNULL(rank), rank ASC');

        if(array_key_exists('states', $filters) && array_key_exists('locations', $filters)) {
            $filters['states'] = array_merge($filters['locations'], $filters['states']);
            unset($filters['locations']);
        }

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
}
