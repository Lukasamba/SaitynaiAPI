<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin',
            'display_name' => 'Admin', // optional
            'description' => 'something...', // optional
        ]);

        Role::create([
            'name' => 'manager',
            'display_name' => 'Manager', // optional
            'description' => 'something...', // optional
        ]);

        Role::create([
            'name' => 'user',
            'display_name' => 'User', // optional
            'description' => 'something...', // optional
        ]);
    }
}
