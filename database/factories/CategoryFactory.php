<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Category::class, function (Faker $faker) {
    return [
        'template' => rand(1, 3),
        'name' => $faker->word
    ];
});
