<?php

namespace App\Http\Responses\Movie;

use Spatie\LaravelData\Data;

final class MovieResponse extends Data
{
    public function __construct(
        public string $name,
        public string $genre,
        public string $length,
        public string $image_url,
    )
    {
    }
}
