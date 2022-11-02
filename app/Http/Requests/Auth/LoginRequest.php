<?php

namespace App\Http\Requests\Auth;

use App\Helpers\Validation\CommonRequestValidationRules;
use Spatie\LaravelData\Data;

class LoginRequest extends Data
{
    public function __construct(
        public string $email,
        public string $password,
    )
    {
    }

    public static function rules(): array
    {
        return [
            'email' => CommonRequestValidationRules::EMAIL_REQUIRED,
            'password' => CommonRequestValidationRules::PASSWORD_REQUIRED,
        ];
    }
}
