<?php

use App\Models\JobPost;
use Faker\Generator as Faker;

$factory->define(App\Models\JobQuote::class, function (Faker $faker) {
    return [
        'job_post_id' => factory(JobPost::class)->create()->id,
        'specs' => array(
            'costs' => [100, 200, 30.56],
            'titles' => ['title 1', 'title 2', 'title 3'],
            'notes' => ['note 1', 'note 2', 'note 3']
        ),
        'milestones' => array(
            'percents' => [30, 20, 50],
            'due_dates' => ['july 1, 2018', 'august 2, 2018', 'september 5, 2018'],
            'descs' => ['desc 1', 'desc 2', 'desc 3']
        ),
        'desc' => 'hello world',
        'message' => 'test message',
        'duration' => 'july 1, 2019',
        'logo' => $faker->image,
        'conditional' => true,
        'status' => 'pending'
    ];
});
