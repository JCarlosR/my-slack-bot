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
            $requestContent = $request->getContent();
            $contentData = json_decode($request->getContent());
            $event = $contentData->event;
            // dd($event);

            if ($event->channel === env('TARGET_CHANNEL_ID')) {
                $this->storeRequest(
                    $request->fullUrl(),
                    $requestContent,
                    $request->method(),
                    $response->getContent()
                );
            }
        }
    }

    private function storeRequest(string $url, $content, string $method, $response)
    {
        $httpRequest = new HttpRequest();

        $httpRequest->request_url = $url;
        $httpRequest->request_content = $content;
        $httpRequest->request_method = $method;

        $httpRequest->response = $response;

        $httpRequest->save();
    }
}
