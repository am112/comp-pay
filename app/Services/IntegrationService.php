<?php

namespace App\Services;

use Illuminate\Support\Str;

final class IntegrationService
{
    public function generateAuthenticationKey(): string
    {
        return hash('sha256', Str::random(40));
    }
}
