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
        // dd($request->all());
        $httpRequest = new HttpRequest();

        $httpRequest->request_url = $request->fullUrl();
        $httpRequest->request_content = $request->getContent();
        $httpRequest->request_method = $request->method();

        $httpRequest->response = $response->getContent();

        $httpRequest->save();
    }
}
