<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusOperatorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role === config('roles.bus_operator')){
            return $next($request);
        }

        return response()->json([
            'success' => false,
            'response' => [
                'error' => 'access denied',
                'status code' => 403,
            ]
            ]);
    }
}
