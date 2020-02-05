<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Vendor::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\Models\User::class)->states('vendor')->create()->id;
        },
        'business_name' => $faker->company,
        'trading_name' => $faker->company,
    ];
});
