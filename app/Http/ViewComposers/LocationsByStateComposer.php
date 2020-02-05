<?php

namespace App\Http\ViewComposers;

use App\Models\Location;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class LocationsByStateComposer
{
    public function compose(View $view)
    {
        $locationsByState = Cache::rememberForever(
            'cached-locationsByState',
            function () {
                $locations = Location::orderBy('name')
                    ->get(['id', 'name', 'state', 'abbr'])
                    ->sortBy('name')
                    ->groupBy('state')
                    ->toArray();
                ksort($locations);
                uksort($locations, function($a, $b) {
                    if ($a == 'Australian Capital Territory' && $b == 'New South Wales') { return 1; }
                    if (($a == 'Australian Capital Territory' || $a == 'Northern Territory' || $a == 'Queensland' || $a == 'South Australia' || $a == 'Tasmania') && $b == 'Victoria') { return 1; }
                    if ($a == 'Northern Territory' && ($b == 'Queensland' || $b == 'South Australia' || $b == 'Western Australia' || $b == 'Victoria')) { return 1; }
                    if (($a == 'Northern Territory' || $a == 'Tasmania') && $b == 'Western Australia' ) { return 1; }
                });

                // Put Sydney first on NSW
                $key = array_search('Sydney', array_column($locations['New South Wales'], 'name'));
                array_unshift($locations['New South Wales'], $locations['New South Wales'][$key]);
                $locations['New South Wales'] = array_unique($locations['New South Wales'], SORT_REGULAR);

                // Put Melboune first on Victoria
                $key = array_search('Melbourne', array_column($locations['Victoria'], 'name'));
                array_unshift($locations['Victoria'], $locations['Victoria'][$key]);
                $locations['Victoria'] = array_unique($locations['Victoria'], SORT_REGULAR);

                // Put Perth And Surrounds first on Western Australia
                $key = array_search('Perth And Surrounds', array_column($locations['Western Australia'], 'name'));
                array_unshift($locations['Western Australia'], $locations['Western Australia'][$key]);
                $locations['Western Australia'] = array_unique($locations['Western Australia'], SORT_REGULAR);

                // Put Darwin & Surrounds first on Northern Territory
                $key = array_search('Darwin & Surrounds', array_column($locations['Northern Territory'], 'name'));
                array_unshift($locations['Northern Territory'], $locations['Northern Territory'][$key]);
                $locations['Northern Territory'] = array_unique($locations['Northern Territory'], SORT_REGULAR);
                
                return collect($locations)->chunk(3)->toArray();
            }
        );

        $view->with('locationsByState', $locationsByState);
    }

    public function search($exif, $field)
    {
        foreach ($exif as $data) {
            if ($data['label'] == $field)
                return $data['raw']['_content'];
        }
    }
}
