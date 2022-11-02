<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => 'something',
        ];
    }

    public function admin()
    {
        return $this->state([
            'name' => 'admin',
            'display_name' => 'Admin',
        ]);
    }

    public function manager()
    {
        return $this->state([
            'name' => 'manager',
            'display_name' => 'Manager',
        ]);
    }

    public function user()
    {
        return $this->state([
            'name' => 'user',
            'display_name' => 'User',
        ]);
    }
}
