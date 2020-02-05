<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $propertyTypes = collect([
            'Country', 'Beach', 'Waterfront', 'Mountains', 'Boats & Floating Venues',
            'Wineries & Breweries', 'Restaurants & Bars', 'Churches & Chapels',
            'Ecofriendly Venues', 'Gardens, Parks & Reserves', 'Orchards & Vineyards',
            'Private Properties', 'Extra Large Venues', 'Art Galleries & Museums',
            'Contemporary Venues', 'Indoor Ceremony Venues', 'Scout Halls',
            'Sailing Clubs', 'Golf Courses', 'Surf Life Saving Clubs',
        ])->reduce(function ($propertyTypes, $type) {
            $propertyTypes[] = [
                'name' => $type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            return $propertyTypes;
        });

        DB::table('property_types')->insert($propertyTypes);
    }
}
