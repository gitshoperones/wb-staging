<?php

use Faker\Generator as Faker;

$factory->define(App\Models\PropertyFeature::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement([
            'AV System', 'Bar Area', 'Bathrooms', 'BYO Alcohol', 'BYO Catering',
            'Camping Grounds', 'Chapel', 'Without Curfew', 'Generator', 'Kitchen',
            'Allows Marquees or Tents', 'Parking', 'Pet Friendly', 'Pool',
            'Sleeping Accommodation'
        ]),
    ];
});
