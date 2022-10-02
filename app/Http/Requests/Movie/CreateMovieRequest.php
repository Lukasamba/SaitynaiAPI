<?php

namespace App\Http\Requests\Movie;

use App\Helpers\Validation\CommonRequestValidationRules;
use Spatie\LaravelData\Data;

class CreateMovieRequest extends Data
{
    public function __construct(
        public string $name,
        public string $genre,
        public string $length,
        public string $image_url,
    )
    {
    }

    public static function rules(): array
    {
        return [
            'name' => CommonRequestValidationRules::STRING_REQUIRED,
            'genre' => CommonRequestValidationRules::STRING_REQUIRED,
            'length' => CommonRequestValidationRules::STRING_REQUIRED,
            'image_url' => CommonRequestValidationRules::STRING_REQUIRED,
        ];
    }
}
