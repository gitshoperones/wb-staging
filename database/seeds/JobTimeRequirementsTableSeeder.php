<?php

use Illuminate\Database\Seeder;

class JobTimeRequirementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeRequirements = collect([
            'Morning', 'Afternoon', 'Evening', 'All Day', 'Multiple Days',
            'I Don\'t Know Yet',
        ])->reduce(function ($timeRequirements, $req) {
            $timeRequirements[] = [
                'name' => $req,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            return $timeRequirements;
        });

        DB::table('job_time_requirements')->insert($timeRequirements);
    }
}
