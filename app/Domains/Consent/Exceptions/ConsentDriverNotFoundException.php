<?php

namespace App\Domains\Consent\Exceptions;

use RuntimeException;

final class ConsentDriverNotFoundException extends RuntimeException
{
    public function __construct(string $driver)
    {
        parent::__construct("Consent driver [$driver] not configured.");
    }
}
