<?php

namespace App\Http\Responses\Auth;

use Spatie\LaravelData\Data;

class LoginUserResponse extends Data
{
    public function __construct(
        public string $access_token,
        public string $token_type = 'bearer',
    )
    {
    }
}
