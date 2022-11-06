<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::query()->where('email')->exists()) {
            $user = User::factory()->admin()->create();
            $role = Role::query()->where('name', 'admin')->first();
            $user->attachRole($role);
        }

        $user = User::factory()->create();
        $role = Role::query()->where('name', 'user')->first();
        $user->attachRole($role);
    }
}
