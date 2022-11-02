<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Tymon\JWTAuth\JWT;

class JwtMiddleware
{
    public function __construct(private JWT $jwt)
    {
    }

    public function handle(Request $request, Closure $next): mixed
    {
        try {
            $this->jwt->parseToken()->getPayload();

            return $next($request);
        } catch (Exception $e) {
        }

        throw new UnauthorizedException();
    }
}
