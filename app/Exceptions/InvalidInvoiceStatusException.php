<?php

namespace App\Exceptions;

use RuntimeException;

final class InvalidInvoiceStatusException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
