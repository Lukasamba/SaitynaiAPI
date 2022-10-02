<?php

namespace App\Http\Requests\Division;

use App\Helpers\Validation\CommonRequestValidationRules;
use Spatie\LaravelData\Data;

class CreateDivisionRequest extends Data
{
    public function __construct(
        public string $address,
        public int $halls_count,
    )
    {
    }

    public static function rules(): array
    {
        return [
            'address' => CommonRequestValidationRules::STRING_REQUIRED,
            'halls_count' => CommonRequestValidationRules::NUMERIC_REQUIRED,
        ];
    }
}
