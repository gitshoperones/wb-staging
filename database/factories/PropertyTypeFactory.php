<?php

use Faker\Generator as Faker;

$factory->define(App\Models\PropertyType::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement([
            'Country', 'Beach', 'Waterfront', 'Mountains', 'Boats & Floating Venues',
            'Wineries & Breweries', 'Restaurants & Bars', 'Churches & Chapels',
            'Ecofriendly Venues', 'Gardens, Parks & Reserves', 'Orchards & Vineyards',
            'Private Properties', 'Extra Large Venues', 'Art Galleries & Museums',
            'Contemporary Venues', 'Indoor Ceremony Venues', 'Scout Halls',
            'Sailing Clubs', 'Golf Courses', 'Surf Life Saving Clubs',
        ]),
    ];
});
