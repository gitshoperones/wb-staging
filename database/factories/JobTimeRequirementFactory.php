<?php

use Faker\Generator as Faker;

$factory->define(App\Models\JobTimeRequirement::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement([
            'Morning', 'Afternoon', 'Evening', 'All Day', 'Multiple Days',
            'I Don\'t Know Yet',
        ]),
    ];
});
