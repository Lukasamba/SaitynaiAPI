<?php

namespace App\Http\Requests\Auth;

use App\Helpers\Validation\CommonRequestValidationRules;
use App\Models\User;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;

class RegisterRequest extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    )
    {
    }

    public static function rules(): array
    {
        return [
            'name' => CommonRequestValidationRules::STRING_REQUIRED,
            'email' => [
                Rule::unique(User::class),
                ...CommonRequestValidationRules::EMAIL_REQUIRED
            ],
            'password' => [
                'confirmed',
                ...CommonRequestValidationRules::PASSWORD_REQUIRED,
            ],
        ];
    }
}
