<?php

use Illuminate\Database\Seeder;
use App\Models\BackpackUser;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BackpackUser::create([
            'email' => 'admin@admin.com',
            'login' => 'admin',
            'password' => bcrypt('adminadmin'),
            'name' => 'Admin',
            'email_verified_at' => date('Y-m-d H:i:s'),
        ])->assignRole('superadmin');

        BackpackUser::create([
            'name' => 'admin',
            'login' => 'admin',
            'email' => 's.breussov@gmail.com',
            'password' => bcrypt('2f8zDs5mWqQUSxhW'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ])->assignRole('superadmin');

    }
}
