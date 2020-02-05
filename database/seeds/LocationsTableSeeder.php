<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = collect([
            ['city' => 'Canberra & Surrounds', 'state' => 'Australian Capital Territory', 'abbr' => 'ACT'],
            ['city' => 'Brisbane', 'state' => 'Queensland', 'abbr' => 'QLD'],
            ['city' => 'Gold Coast', 'state' => 'Queensland', 'abbr' => 'QLD'],
            ['city' => 'Sunshine Coast', 'state' => 'Queensland', 'abbr' => 'QLD'],
            ['city' => 'Bundaberg', 'state' => 'Queensland', 'abbr' => 'QLD'],
            ['city' => 'Capricorn', 'state' => 'Queensland', 'abbr' => 'QLD'],
            ['city' => 'Fraser Coast', 'state' => 'Queensland', 'abbr' => 'QLD'],
            ['city' => 'Gladstone', 'state' => 'Queensland', 'abbr' => 'QLD'],
            ['city' => 'The Whitsundays', 'state' => 'Queensland', 'abbr' => 'QLD'],
            ['city' => 'Great Barrier Reef', 'state' => 'Queensland', 'abbr' => 'QLD'],
            ['city' => 'Mackay', 'state' => 'Queensland', 'abbr' => 'QLD'],
            ['city' => 'Outback Queensland', 'state' => 'Queensland', 'abbr' => 'QLD'],
            ['city' => 'Southern Queensland Country', 'state' => 'Queensland', 'abbr' => 'QLD'],
            ['city' => 'Townsville', 'state' => 'Queensland', 'abbr' => 'QLD'],
            ['city' => 'Blue Mountains', 'state' => 'New South Wales', 'abbr' => 'NSW'],
            ['city' => 'Central Coast', 'state' => 'New South Wales', 'abbr' => 'NSW'],
            ['city' => 'Country', 'state' => 'New South Wales', 'abbr' => 'NSW'],
            ['city' => 'Hunter Valley', 'state' => 'New South Wales', 'abbr' => 'NSW'],
            ['city' => 'Lord Howe Island', 'state' => 'New South Wales', 'abbr' => 'NSW'],
            ['city' => 'North Coast', 'state' => 'New South Wales', 'abbr' => 'NSW'],
            ['city' => 'Outback', 'state' => 'New South Wales', 'abbr' => 'NSW'],
            ['city' => 'Snowy Mountains', 'state' => 'New South Wales', 'abbr' => 'NSW'],
            ['city' => 'South Coast', 'state' => 'New South Wales', 'abbr' => 'NSW'],
            ['city' => 'Sydney City', 'state' => 'New South Wales', 'abbr' => 'NSW'],
            ['city' => 'Byron Bay & Surrounds', 'state' => 'New South Wales', 'abbr' => 'NSW'],
            ['city' => 'Kangaroo Valley', 'state' => 'New South Wales', 'abbr' => 'NSW'],
            ['city' => 'The Murray', 'state' => 'New South Wales', 'abbr' => 'NSW'],
            ['city' => 'Southern Highlands', 'state' => 'New South Wales', 'abbr' => 'NSW'],
            ['city' => 'Darwin & Surrounds', 'state' => 'Northern Territory', 'abbr' => 'NT'],
            ['city' => 'Alice Springs & Surrounds', 'state' => 'Northern Territory', 'abbr' => 'NT'],
            ['city' => 'Uluru & Surrounds', 'state' => 'Northern Territory', 'abbr' => 'NT'],
            ['city' => 'Kakadu', 'state' => 'Northern Territory', 'abbr' => 'NT'],
            ['city' => 'Katherine & Surrounds', 'state' => 'Northern Territory', 'abbr' => 'NT'],
            ['city' => 'Arnhem Land', 'state' => 'Northern Territory', 'abbr' => 'NT'],
            ['city' => 'Tennant Creek & Barkly Region', 'state' => 'Northern Territory', 'abbr' => 'NT'],
            ['city' => 'Adelaide', 'state' => 'South Australia', 'abbr' => 'SA'],
            ['city' => 'Adelaide Hills', 'state' => 'South Australia', 'abbr' => 'SA'],
            ['city' => 'Barossa', 'state' => 'South Australia', 'abbr' => 'SA'],
            ['city' => 'Clare Valley', 'state' => 'South Australia', 'abbr' => 'SA'],
            ['city' => 'Eyre Peninsula', 'state' => 'South Australia', 'abbr' => 'SA'],
            ['city' => 'Fleurieu Peninsula', 'state' => 'South Australia', 'abbr' => 'SA'],
            ['city' => 'Flinders Ranges and Outback', 'state' => 'South Australia', 'abbr' => 'SA'],
            ['city' => 'Kangaroo Island', 'state' => 'South Australia', 'abbr' => 'SA'],
            ['city' => 'Limestone Coast', 'state' => 'South Australia', 'abbr' => 'SA'],
            ['city' => 'Murray River, Lakes and Coorong', 'state' => 'South Australia', 'abbr' => 'SA'],
            ['city' => 'Riverland', 'state' => 'South Australia', 'abbr' => 'SA'],
            ['city' => 'Yorke Peninsula', 'state' => 'South Australia', 'abbr' => 'SA'],
            ['city' => 'Launceston & North', 'state' => 'Tasmania', 'abbr' => 'TAS'],
            ['city' => 'East Coast', 'state' => 'Tasmania', 'abbr' => 'TAS'],
            ['city' => 'Hobart and South', 'state' => 'Tasmania', 'abbr' => 'TAS'],
            ['city' => 'West Coast', 'state' => 'Tasmania', 'abbr' => 'TAS'],
            ['city' => 'North West', 'state' => 'Tasmania', 'abbr' => 'TAS'],
            ['city' => 'Daylesford & the Macedon Ranges', 'state' => 'Victoria', 'abbr' => 'VIC'],
            ['city' => 'Geelong & the Bellarine', 'state' => 'Victoria', 'abbr' => 'VIC'],
            ['city' => 'Gippsland', 'state' => 'Victoria', 'abbr' => 'VIC'],
            ['city' => 'Grampians', 'state' => 'Victoria', 'abbr' => 'VIC'],
            ['city' => 'Goldfields', 'state' => 'Victoria', 'abbr' => 'VIC'],
            ['city' => 'High Country', 'state' => 'Victoria', 'abbr' => 'VIC'],
            ['city' => 'Melbourne', 'state' => 'Victoria', 'abbr' => 'VIC'],
            ['city' => 'Morning Peninsula', 'state' => 'Victoria', 'abbr' => 'VIC'],
            ['city' => 'The Murray', 'state' => 'Victoria', 'abbr' => 'VIC'],
            ['city' => 'Phillip Island', 'state' => 'Victoria', 'abbr' => 'VIC'],
            ['city' => 'Yarra Valley & Dandenong Ranges', 'state' => 'Victoria', 'abbr' => 'VIC'],
            ['city' => 'Perth and Surrounds', 'state' => 'Western Australia', 'abbr' => 'WA'],
            ['city' => 'Margaret River & South West', 'state' => 'Western Australia', 'abbr' => 'WA'],
            ['city' => 'Exmouth & the Coral Coast', 'state' => 'Western Australia', 'abbr' => 'WA'],
            ['city' => 'Broome & the North West', 'state' => 'Western Australia', 'abbr' => 'WA'],
            ['city' => 'Esperance & the Golden Outback', 'state' => 'Western Australia', 'abbr' => 'WA'],
            ['city' => 'Australia Wide', 'state' => 'Australia Wide', 'abbr' => ''],
        ])->reduce(function ($locations, $location) {
            $locations[] = [
                'name' => $location['city'],
                'abbr' => $location['abbr'],
                'state' => $location['state'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            return $locations;
        });

        DB::table('locations')->insert($locations);
    }
}
