<?php

namespace App\Http\Responses\Division;

use Spatie\LaravelData\Data;

final class DivisionsTableResponse extends Data
{
    public function __construct(
        public int $id,
        public string $address,
        public int $halls_count,
    )
    {
    }
}
