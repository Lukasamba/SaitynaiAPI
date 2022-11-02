<?php

namespace Database\Seeders;

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
            User::factory()->admin()->create();
        }

        User::factory()->user()->count(3)->create();
    }
}
