<?php

namespace App\Http\Responses\Movie;

use Spatie\LaravelData\Data;

final class MoviesTableResponse extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $genre,
        public string $length,
        public string $image_url,
    )
    {
    }
}
