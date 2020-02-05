<?php

use Illuminate\Database\Seeder;

class PropertyFeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $requirements = collect([
            'AV System', 'Bar Area', 'Bathrooms', 'BYO Alcohol', 'BYO Catering',
            'Camping Grounds', 'Chapel', 'Without Curfew', 'Generator', 'Kitchen',
            'Allows Marquees or Tents', 'Parking', 'Pet Friendly', 'Pool',
            'Sleeping Accommodation'
        ])->reduce(function ($requirements, $requirement) {
            $requirements[] = [
                'name' => $requirement,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            return $requirements;
        });

        DB::table('property_features')->insert($requirements);
    }
}
