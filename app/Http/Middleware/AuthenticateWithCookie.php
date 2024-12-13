<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Providers\Auth\Illuminate;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthenticateWithCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Retrieve the JWT token from the cookie
            $token = $request->cookie('jwt_token');

            if (!$token) {
                return redirect('/signin')->withErrors(['error' => 'Authentication token not found.']);
            }

            // Authenticate the user using the token
            $user = JWTAuth::setToken($token)->authenticate();

            if (!$user) {
                return redirect('/signin')->withErrors(['error' => 'Invalid authentication token.']);
            }

            // Optionally, share the authenticated user with the request
            $request->merge(['auth_user' => $user]);
        } catch (JWTException $e) {
            return redirect('/signin')->withErrors(['error' => 'Token error: ' . $e->getMessage()]);
        }

        return $next($request);
    }
}
