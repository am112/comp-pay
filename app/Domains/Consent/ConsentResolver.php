<?php

namespace App\Domains\Consent;

use App\Domains\Consent\Contracts\ConsentContract;
use App\Domains\Consent\Exceptions\ConsentDriverNotFoundException;

final class ConsentResolver
{
    public static function resolve(string $driver): ConsentContract
    {
        $class = config('driver.consent.drivers.'.$driver);

        if (! $class) {
            throw new ConsentDriverNotFoundException($driver);
        }

        return app($class);
    }
}
