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
        ]);
    }

    public function manager()
    {
        return $this->state([
            'name' => 'manager',
            'email' => 'manager@saitynai.com',
            'password' => Hash::make('password'),
        ]);
    }
}
