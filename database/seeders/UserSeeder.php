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
        $roleAdmin = Role::query()->where('name', 'admin')->first();
        $roleManager = Role::query()->where('name', 'manager')->first();
        $roleUser = Role::query()->where('name', 'user')->first();

        if (!User::query()->where('email')->exists()) {
            $user = User::factory()->admin()->create();
            $user->attachRoles([$roleAdmin, $roleManager, $roleUser]);
        }

        /** @var User $manager */
        $manager = User::factory()->manager()->create();
        $manager->attachRoles([$roleManager, $roleUser]);

        /** @var User $user */
        $user = User::factory()->create();
        $user->attachRole($roleUser);
    }
}
