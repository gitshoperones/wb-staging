<?php

use App\Models\User;
use App\Models\Media;
use App\Models\Couple;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vendor users
        $vendorUsers = factory(User::class, 10)->states('vendor')->create();
        foreach ($vendorUsers as $user) {
            factory(Vendor::class)->create(['user_id' => $user->id]);
        }

        // Couple Users
        $coupleUsers = factory(User::class, 10)->states('couple')->create();
        foreach ($coupleUsers as $user) {
            factory(Couple::class)->create(['userA_id' => $user->id]);
        }
    }
}
