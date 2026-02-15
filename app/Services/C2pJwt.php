<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final readonly class C2pJwt
{
    public function __construct(
        private string $key,
        private string $algo
    ) {}

    public function encode(array $payload): string
    {
        return JWT::encode($payload, $this->key, $this->algo);
    }

    public function decode(string $payload): array
    {
        return (array) JWT::decode($payload, new Key($this->key, $this->algo));
    }
}
