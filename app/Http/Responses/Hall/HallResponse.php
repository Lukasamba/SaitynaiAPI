<?php

namespace App\Http\Responses\Hall;

use Spatie\LaravelData\Data;

final class HallResponse extends Data
{
    public function __construct(
        public string $name,
        public int $seats_count,
        public int $division_id,
    )
    {
    }
}
