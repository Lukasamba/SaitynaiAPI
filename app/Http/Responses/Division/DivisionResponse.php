<?php

namespace App\Http\Responses\Division;

use Spatie\LaravelData\Data;

final class DivisionResponse extends Data
{
    public function __construct(
        public string $address,
        public int $halls_count,
    )
    {
    }
}
