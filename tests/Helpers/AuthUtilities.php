<?php

namespace Tests\Helpers;

use App\Models\User;
use Auth;
use JetBrains\PhpStorm\ArrayShape;

trait AuthUtilities
{
    protected ?User $user = null;

    protected array $authHeader = [];

    protected function login(User $user): string
    {
        $route = 'api/auth/login';
        $res = $this
            ->post($route, [
                'email' => $user->email,
                'password' => $this->generic_password,
            ])
            ->assertStatus(200);

        $token = $res->json('access_token');
        $this->assertNotEmpty($token);

        $this->user = Auth::user();
        $this->authHeader = $this->authHeader($token);

        return $token;
    }

    protected function logout(bool $bo = false): void
    {
        $route = 'api/auth/logout';
        $this
            ->post($route)
            ->assertStatus(200);

        $this->user = null;
        $this->authHeader = [];
    }

    protected function isLogged(User $user): bool
    {
        return Auth::user()?->id === $user->id;
    }

    #[ArrayShape(['Authorization' => "string"])]
    private function authHeader(string $token): array
    {
        return ['Authorization' => "Bearer {$token}"];
    }
}
