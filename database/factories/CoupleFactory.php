<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Couple::class, function (Faker $faker) {
    return [
        'userA_id' => function () {
            return factory(App\Models\User::class)->states('couple')->make()->id;
        },
        'title' => $faker->firstNameMale.' & '.$faker->firstNameFemale,
    ];
});
