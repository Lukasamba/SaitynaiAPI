<?php

namespace App\Http\Responses\Movie;

use Spatie\LaravelData\Data;

class ReservationsTabelResponse extends Data
{
    public function __construct(
        public ?int $user_id,
        public string $name,
        public string $reservation_date,
    )
    {
    }
}
