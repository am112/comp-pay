<?php

namespace App\Services;

use App\Services\Exceptions\C2pRequestFailedException;
use Illuminate\Support\Facades\Http;

final class C2pClient
{
    public function __construct(private string $domain) {}

    public function post(string $path, array|string $payload, array $headers = ['Content-Type' => 'application/json']): array|string
    {
        $response = Http::timeout(30)
            ->withHeaders($headers)
            ->retry(1, 200)
            ->post($this->domain.$path, is_array($payload)
                ? $payload
                : $payload
            );

        if (! $response->successful()) {
            throw new C2pRequestFailedException(
                'C2P HTTP error',
                $response->status()
            );
        }

        if ($headers['Content-Type'] !== 'application/json') {
            return $response->body();
        }

        return $response->json();
    }
}
