<?php

namespace App\Domains\InstantPayment;

use App\Domains\InstantPayment\Contracts\InstantPaymentContract;

final class InstantPaymentResolver
{
    public static function resolve(string $driver): InstantPaymentContract
    {
        $class = config('driver.instant.drivers.'.$driver);

        if (! $class) {
            throw new \Exception('instant driver not found');
        }

        return app($class);
    }
}
