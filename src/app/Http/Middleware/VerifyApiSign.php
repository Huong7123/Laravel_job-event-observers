<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiSign
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sign = $request->header('X-Api-Sign') ?? $request->query('sign');

        if (!$sign) {
            return response()->json([
                'success' => false,
                'message' => 'Missing X-Api-Sign in request header or sign parameter'
            ], 401);
        }

        if (!\App\Models\User::where('sign', $sign)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API Sign'
            ], 401);
        }

        return $next($request);
    }
}
