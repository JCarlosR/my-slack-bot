<?php

namespace App\Http\Middleware;

use App\HttpRequest;
use Closure;

class LogAfterRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        if ($request->headers->get('Content-Type') == 'application/json') {
            HttpRequest::createFrom($request, $response);
        }
    }
}
