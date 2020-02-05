<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventLists = collect([
            'Wedding Day', 'Wedding Rehearsal', 'Wedding Recovery', 'Engagement Party',
            'Bridal Shower', 'Kitchen Tea', 'Other Event',
        ])->reduce(function ($eventLists, $event) {
            $eventLists[] = [
                'name' => $event,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            return $eventLists;
        });

        DB::table('events')->insert($eventLists);
    }
}
