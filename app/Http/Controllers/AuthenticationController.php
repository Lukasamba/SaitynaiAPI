<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\Auth\LoginUserResponse;
use App\Models\User;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{
    private Factory|Application|StatefulGuard|Guard|JWTAuth $auth;

    public function __construct()
    {
        $this->auth = auth();
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->saveOrFail();

        return response()->json();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->auth->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($token == '') {
            return abort(422, 'Invalid email or password.');
        }

        return response()->json(LoginUserResponse::from([
            'access_token' => $token,
        ]));
    }

    public function logout(): JsonResponse
    {
        $this->auth->logout();

        return response()->json();
    }
}
