<?php

use App\Models\Event;
use App\Models\JobCategory;
use App\Models\JobTimeRequirement;
use Faker\Generator as Faker;

$factory->define(App\Models\JobPost::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return App\Models\User::where('account', 'couple')->inRandomOrder()->first()->id;
        },
        'category_id' => function () {
            return App\Models\JobCategory::inRandomOrder()->first()->id;
        },
        'event_id' => function () {
            return App\Models\Event::inRandomOrder()->first()->id;
        },
        'event_date' => date('F j, Y', mt_rand(strtotime("+1 day"), strtotime("+10 week"))),
        'budget' => rand(10000, 50000),
        'shipping_address' => [
            'street' => $faker->streetAddress,
            'suburb' => $faker->city,
            'state' => $faker->state,
            'post_code' => $faker->postcode,
        ],
        'job_time_requirement_id' => function () {
            return App\Models\JobTimeRequirement::inRandomOrder()->first()->id;
        },
        'required_address' => $faker->address,
        'completion_date' => $faker->date('F j, Y'),
        'number_of_guests' => rand(100, 400),
        'specifics' => $faker->paragraph,
        'status' => 1
    ];
});
