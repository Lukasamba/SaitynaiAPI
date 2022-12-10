<?php

namespace App\Http\Responses\Movie;

use Spatie\LaravelData\Data;

class ReservationsTabelResponse extends Data
{
    public function __construct(
        public string $name,
        public string $reservation_date,
    )
    {
    }
}
