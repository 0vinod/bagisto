<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMobileApp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
      public function handle(Request $request, Closure $next)
    {
        $key      = (string) $request->header('X-App-Key');
        $platform = strtolower((string) $request->header('X-Platform'));

        if (!hash_equals((string) config('services.mobile_app.key'), $key)
            || !in_array($platform, ['android', 'ios'], true)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
