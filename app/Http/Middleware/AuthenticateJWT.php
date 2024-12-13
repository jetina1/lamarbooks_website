<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateJWT
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Check if the token is valid
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            // Handle token errors
            return response()->json(['message' => 'Unauthorized: ' . $e->getMessage()], 401);
        }

        // Allow the request to continue
        return $next($request);
    }
}
