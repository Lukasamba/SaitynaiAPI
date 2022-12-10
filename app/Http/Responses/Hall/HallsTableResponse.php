<?php

namespace App\Http\Responses\Hall;

use App\Models\Division;
use App\Models\Hall;
use Spatie\LaravelData\Data;

final class HallsTableResponse extends Data
{
    public function __construct(
        public int $id,
        public int $division_id,
        public string $division_address,
        public string $name,
        public int $seats_count,
    )
    {
    }

    /**
     * @param Hall $payload
     * @return static
     */
    public static function fromModel($payload): static
    {
        $divisionAddress = Division::query()->where('id', $payload->division_id)->pluck('address');

        return new self(
            id: $payload->getKey(),
            division_id: $payload->division_id,
            division_address: $divisionAddress,
            name: $payload->name,
            seats_count: $payload->seats_count,
        );
    }
}
