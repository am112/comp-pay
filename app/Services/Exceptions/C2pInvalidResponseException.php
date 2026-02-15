<?php

namespace App\Services\Exceptions;

final class C2pInvalidResponseException extends C2pException
{
    public function __construct(
        string $message,
        public readonly string $providerCode
    ) {
        parent::__construct($message);
    }
}
