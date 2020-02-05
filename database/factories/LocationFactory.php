<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Location::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement([
            'Canberra & Surrounds ACT', 'Brisbane QLD', 'Gold Coast QLD', 'Sunshine Coast QLD',
            'Bundaberg QLD', 'Capricorn QLD', 'Fraser Coast QLD', 'Gladstone QLD',
            'The Whitsundays QLD', 'Great Barrier Reef QLD', 'Mackay QLD',
            'Outback Queensland QLD', 'Southern Queensland Country QLD', 'Townsville QLD',
            'Blue Mountains NSW', 'Central Coast NSW', 'Country NSW', 'Hunter Valley NSW',
            'Hunter Valley NSW', 'Lord Howe Island NSW', 'North Coast NSW', 'Outback NSW',
            'Snowy Mountains NSW', 'South Coast NSW', 'Sydney City NSW', 'Darwin & Surrounds NT',
            'Alice Springs & Surrounds NT', 'Uluru & Surrounds NT', 'Kakadu NT',
            'Katherine & Surrounds NT', 'Arnhem Land NT', 'Tennant Creek & Barkly Region NT',
            'Adelaide SA', 'Adelaide Hills SA', 'Barossa SA', 'Clare Valley SA',
            'Eyre Peninsula SA', 'Fleurieu Peninsula SA', 'Flinders Ranges and Outback SA',
            'Kangaroo Island SA', 'Limestone Coast SA', 'Murray River, Lakes and Coorong SA',
            'Riverland SA', 'Yorke Peninsula SA', 'Launceston & North TAS', 'East Coast TAS',
            'Hobart and South TAS', 'West Coast TAS', 'North West TAS', 'Daylesford & the Macedon Ranges VIC',
            'Geelong & the Bellarine VIC', 'Gippsland VIC', 'Grampians VIC', 'Goldfields VIC',
            'High Country VIC', 'Melbourne VIC', 'Morning Peninsula VIC', 'The Murray VIC',
            'Phillip Island VIC', 'Yarra Valley & Dandenong Ranges VIC', 'Perth and Surrounds WA',
            'Margaret River & South West WA', 'Exmouth & the Coral Coast WA', 'Broome & the North West WA',
            'Esperance & the Golden Outback WA'
        ]),
        'state' => $faker->state,
        'abbr' => $faker->city,
    ];
});
