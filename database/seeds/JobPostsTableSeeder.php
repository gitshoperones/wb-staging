<?php

use App\Models\JobPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(JobPost::class, 20)->create()->each(function ($jobPost) {
            $jobPost->locations()->sync(
                App\Models\Location::orderByRaw('RAND()')->take(rand(1, 2))
                ->get()
                ->pluck('id')
            );

            $jobPost->propertyTypes()->sync(
                App\PropertyType::orderByRaw('RAND()')->take(rand(1, 5))
                ->get()
                ->pluck('id')
            );

            $jobPost->otherJobRequirements()->sync(
                App\OtherJobRequirement::orderByRaw('RAND()')->take(rand(1, 5))
                ->get()
                ->pluck('id')
            );

            $jobPost->user->allow('*', $jobPost);
        });
    }
}
