<?php

namespace App\Http\Middleware;

use App\Models\HttpLogInbound;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebhooksInboundIntercepter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        HttpLogInbound::create([
            'url' => $request->getSchemeAndHttpHost().$request->getPathInfo(),
            'method' => $request->getMethod(),
            'headers' => json_encode($request->headers->all()),
            'body' => json_encode($request->all()),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return $next($request);
    }
}
