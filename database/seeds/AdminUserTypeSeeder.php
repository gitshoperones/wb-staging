<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->states('admin')->create([
            'email' => 'hello@wedbooker.com',
            'password' => 'WedbookerAdmin123ABC',
            'fname' => 'Admin',
            'lname' => 'Admin',
        ]);
    }
}
