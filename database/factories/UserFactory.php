<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->email(),
            'password' => Hash::make('password'),
        ];
    }

    public function admin()
    {
        return $this->state([
            'name' => 'admin',
            'email' => 'dev@saitynai.com',
            'password' => Hash::make('password'),
        ])->hasAttached(Role::query()
            ->where('name', 'admin')
            ->first(), [
                'user_type' => 'Admin',
        ], 'roles');
    }

    public function user()
    {
        return $this->state([])->hasAttached(Role::query()
            ->where('name', 'user')
            ->first(), [
            'user_type' => 'User',
        ], 'roles');
    }
}
