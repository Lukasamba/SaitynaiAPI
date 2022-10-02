<?php

namespace App\Http\Requests\Hall;

use App\Helpers\Validation\CommonRequestValidationRules;
use App\Models\Division;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;

class CreateHallRequest extends Data
{
    public function __construct(
        public int $division_id,
        public string $name,
        public int $seats_count,
    )
    {
    }

    public static function rules(): array
    {
        return [
            'division_id' => [
                ...CommonRequestValidationRules::REQUIRED,
                Rule::exists(Division::class, 'id'),
            ],
            'name' => CommonRequestValidationRules::STRING_REQUIRED,
            'seats_count' => CommonRequestValidationRules::NUMERIC_REQUIRED,
        ];
    }
}
