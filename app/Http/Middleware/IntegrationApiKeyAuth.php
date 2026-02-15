<?php

namespace App\Http\Middleware;

use App\Models\Integration;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IntegrationApiKeyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->header('X-API-KEY');

        if (! $key) {
            return response()->json(['message' => 'API key missing'], 401);
        }

        $record = Integration::query()
            ->where('authentication_key', $key)->first();

        if (! $record) {
            return response()->json(['message' => 'Invalid API key'], 401);
        }

        $record->update(['last_seen_at' => now()]);

        $request->merge([
            'integration' => $record,
        ]);

        return $next($request);
    }
}
