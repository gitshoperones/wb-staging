<?php

use Illuminate\Database\Seeder;

class WebsiteRequirementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $req = collect([
            'Wedding Day Details', 'Other Event Details', 'Accommodation Details',
            'Guest RSVPs', 'Gift Registry', 'Transport Details', 'Additional Custom Pages'
        ])->reduce(function ($lists, $item) {
            $lists[] = [
                'name' => $item,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            return $lists;
        });

        DB::table('website_requirements')->insert($req);
    }
}
