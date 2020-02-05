<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Expertise::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement([
            'Wedding Day', 'Wedding Rehearsal', 'Wedding Recovery', 'Hens Party',
            'Bucks Party', 'Engagement Party', 'Bridal Shower', 'Kitchen Tea',
            'Other Event',
        ]),
    ];
});
