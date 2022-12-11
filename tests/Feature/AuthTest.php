<?php

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function testRouteExists(): void
    {
        $resLogin = $this->post('api/auth/login');
        $resRegister = $this->post('api/auth/register');
        $resLogout = $this->post('api/auth/logout');
        $resRefresh = $this->post('api/auth/refresh');

        $this->assertTrue($resLogin->status() !== 404);
        $this->assertTrue($resRegister->status() !== 404);
        $this->assertTrue($resLogout->status() !== 404);
        $this->assertTrue($resRefresh->status() !== 404);
    }

    public function testLoginSuccess(): void
    {
        $this->post('api/auth/login', [
            'email' => 'dev@saitynai.com',
            'password' => 'password'
        ])
            ->assertStatus(200)
            ->assertSee('access_token');
    }

    public function testLoginEmptyData(): void
    {
        $this->post('api/auth/login', [
            'email' => '',
            'password' => ''
        ])->assertStatus(422);
    }

    public function testLoginInvalidData(): void
    {
        $this->post('api/auth/login', [
            'email' => 'bad_data',
            'password' => 'bad_data'
        ])->assertStatus(422);
    }

    public function testRegisterSuccess(): void
    {
        $newUser = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $this->post('api/auth/register', $newUser)->assertStatus(200);

        /** @var User $user */
        $user = User::query()->where('email', $newUser['email'])->first();

        $this->assertNotNull($user);
        $this->assertTrue($newUser['email'] === $user->email);
        $this->assertTrue($newUser['name'] === $user->name);
    }

    public function testRegisterEmptyData(): void
    {
        $this->post('api/auth/register', [])->assertStatus(422);
    }

    public function testRegisterInvalidData(): void
    {
        $newUser = [
            'name' => true,
            'email' => $this->faker->name,
            'password' => '123',
            'password_confirmation' => '321'
        ];

        $this->post('api/auth/register', $newUser)->assertStatus(422);

        /** @var User $user */
        $user = User::query()->where('email', $newUser['email'])->first();

        $this->assertNull($user);
    }

    public function testLogoutSuccess(): void
    {
        $user = User::factory()->create();
        $this->login($user);

        $this->post('api/auth/logout')->assertStatus(200);
        $this->assertNull(Auth::user());
    }

    public function testLogoutFail(): void
    {
        $this->assertNull(Auth::user());
        $this->post('api/auth/logout')->assertStatus(500);
    }

    public function testRefreshTokenSuccess(): void
    {
        $user = User::factory()->create();
        $this->login($user);

        $this->put('api/auth/refresh')
            ->assertStatus(200)
            ->assertSee('access_token');
    }

    public function testRefreshTokenFail(): void
    {
        $this->assertNull(Auth::user());
        $this->put('api/auth/refresh')->assertStatus(500);
    }
}
