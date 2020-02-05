<?php

use Illuminate\Database\Seeder;

class BeautySubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cat = collect([
            'Personal Trainer', 'General Wellness', 'Diet & Nutrition',
            'Facial Treatments'
        ])->reduce(function ($lists, $item) {
            $lists[] = [
                'name' => $item,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            return $lists;
        });

        DB::table('beauty_subcategories')->insert($cat);
    }
}
