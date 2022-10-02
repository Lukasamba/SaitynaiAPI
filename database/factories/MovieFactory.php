<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'movie_' . rand(0, 1000),
            'genre' => Arr::random(['Action', 'Adventure', 'Horror']),
            'length' => Arr::random(['1h 30m', '1h 40m', '1h 50m']),
            'image_url' => 'https://url...',
        ];
    }
}
