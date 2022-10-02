<?php

namespace App\Http\Responses\Hall;

use Spatie\LaravelData\Data;

final class HallsTableResponse extends Data
{
    public function __construct(
        public int $id,
        public int $division_id,
        public string $name,
        public int $seats_count,
    )
    {
    }
}
