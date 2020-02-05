<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Media::class, function (Faker $faker) {
    return [
        'commentable_id' => 1,
        'commentable_type' => 'App\\User',
        'meta_key' => $faker->word,
        'meta_title' => $faker->sentence,
        'meta_description' => $faker->paragraph,
        'meta_filename' => '',
    ];
});
