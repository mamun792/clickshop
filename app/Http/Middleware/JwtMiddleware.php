<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Update path checks to include v1 prefix
        if ($request->is('v1/register') || $request->is('api/v1/register')) {
            return $next($request);
        }

        // if ($request->is('v1/login') || $request->is('api/v1/login')) {
        //     return $next($request);
        // }
        // if ($request->is('v1/register') || $request->is('api/v1/register')) {
        //     return $next($request);
        // }

        // if ($request->is('v1/login') || $request->is('api/v1/login')) {
        //     return $next($request);
        // }


        // $allowedRoutes = config('routes.allowed_routes', []);
        // if (in_array($request->path(), $allowedRoutes, true)) {
        //     return $next($request);
        // }

        //     try {
        //     $user = JWTAuth::parseToken()->authenticate();
        //     if (!$user) {
        //         return response()->json(['error' => 'User not found'], 404);
        //     }
            
        // } catch (JWTException $e) {
        //     return response()->json(['error' => 'Token not valid'], 401);
        // } catch (Exception $e) {
        //     return response()->json(['error' => 'Token error'], 500);
        // }

        return $next($request);
    }
}
