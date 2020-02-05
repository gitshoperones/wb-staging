<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect([
            ['order' => 2, 'icon' => 'marqees-and-tipis.png', 'template' => 2, 'name' => 'Marquees and Tipis'],
            ['order' => 9, 'icon' => 'Food-catering.png', 'template' => 2, 'name' => 'Catering'],
            ['order' => 6, 'icon' => 'celebrants.png', 'template' => 2, 'name' => 'Celebrants'],
            ['order' => 4, 'icon' => 'photographer.png', 'template' => 2, 'name' => 'Celebrants'],
            ['order' => 3, 'icon' => 'florist.png', 'template' => 2, 'name' => 'Florists'],
            ['order' => 14, 'icon' => 'wedding-planning.png', 'template' => 2, 'name' => 'Wedding Planners'],
            ['order' => 7, 'icon' => 'wedding-band.png', 'template' => 2, 'name' => 'Entertainment and MCs'],
            ['order' => 17, 'icon' => 'transport.png', 'template' => 2, 'name' => 'Transport'],
            ['order' => 8, 'icon' => 'invitations.png', 'template' => 3, 'name' => 'Invitations and Stationery'],
            ['order' => 11, 'icon' => 'cakes-and-desserts.png', 'template' => 2, 'name' => 'Cakes and Desserts'],
            ['order' => 16, 'icon' => 'furniture-and-prop-hire.png', 'template' => 2, 'name' => 'Furniture and Props'],
            ['order' => 12, 'icon' => 'hair.png', 'template' => 2, 'name' => 'Hair'],
            ['order' => 13, 'icon' => 'make-up.png', 'template' => 2, 'name' => 'Makeup'],
            ['order' => 5, 'icon' => 'videographer.png', 'template' => 2, 'name' => 'Videographers'],
            ['order' => 18, 'icon' => 'wedding-websites.png', 'template' => 2, 'name' => 'Wedding Websites'],
            ['order' => 20, 'icon' => 'baby-sitters.png', 'template' => 2, 'name' => 'Babysitters'],
            ['order' => 24, 'icon' => 'special-touches.png', 'template' => 2, 'name' => 'Wedding Favours and Special Touches'],
            ['order' => 1, 'icon' => 'venue-hire.png', 'template' => 1, 'name' => 'Venues'],
            ['order' => 19, 'icon' => 'Fireworks_navy.png', 'template' => 1, 'name' => 'Fireworks'],
            ['order' => 21, 'icon' => 'Portable-loos_navy.png', 'template' => 3, 'name' => 'Portable Restrooms'],
            ['order' => 15, 'icon' => 'event-styling.png', 'template' => 2, 'name' => 'Wedding Stylists'],
            ['order' => 23, 'icon' => 'health-and-wellness.png', 'template' => 2, 'name' => 'Beauty and Wellness'],
        ])->reduce(function ($categories, $category) {
            $categories[] = [
                'template' => $category['template'],
                'order' => $category['order'],
                'icon' => $category['icon'],
                'name' => $category['name'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            return $categories;
        });

        DB::table('categories')->insert($categories);
    }
}
