<?php

namespace App\Domains\Collection;

use App\Domains\Collection\Contracts\CollectionContract;

final class CollectionResolver
{
    public static function resolve(string $driver): CollectionContract
    {
        $class = config('driver.collection.drivers.'.$driver);

        if (! $class) {
            throw new \Exception('Collection driver not found');
        }

        return app($class);
    }
}
