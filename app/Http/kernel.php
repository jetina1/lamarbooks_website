<? php
 protected $routeMiddleware = [
// other middleware...
'auth' => \App\Http\Middleware\AuthenticateJWT::class,
'jwt.auth' => \App\Http\Middleware\AuthenticateJWT::class,
'auth.cookie' => \App\Http\Middleware\AuthenticateWithCookie::class
// 'jwt.auth' => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,

];
