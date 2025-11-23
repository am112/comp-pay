<?php

namespace App\Domains\Mandate;

use App\Domains\Mandate\Contracts\MandateContract;

final class MandateResolver
{
    public static function resolve(string $driver): MandateContract
    {
        $class = config('driver.mandate.drivers.'.$driver);

        if (! $class) {
            throw new \Exception('Mandate driver not found');
        }

        return app($class);
    }
}
