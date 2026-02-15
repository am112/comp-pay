<?php

namespace App\Domains\Consent\Exceptions;

use RuntimeException;

final class ConsentExistException extends RuntimeException
{
    public function __construct(
        string $message,
        public readonly string $providerCode
    ) {
        parent::__construct($message);
    }
}
