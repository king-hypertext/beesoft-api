<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        foreach ($roles as $role) {
            if (!$request->user()->hasRole($role)) {
                return response()->json(['message' => 'Unauthorized', 'additional_info' => 'You are not allowed to perform this acction'], Response::HTTP_UNAUTHORIZED);
            }
        }
        return $next($request);
    }
}
