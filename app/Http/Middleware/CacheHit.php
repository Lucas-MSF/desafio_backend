<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheHit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $pathInfo = $request->getPathInfo();
        $uri = $request->getRequestUri();
        $cacheKey = 'request-user' . auth()->id() . $uri;

        $status = Cache::has($cacheKey) ? 'hit' : 'miss';
        $response = Cache::tags([$pathInfo])->remember($cacheKey, now()->addMonth(), function () use ($next, $request) {
            return $next($request);
        });
        $response->headers->set('x-cache', $status);

        return $response;
    }
}
