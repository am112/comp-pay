<?php

namespace App\Services;

final class DriverService
{
    public function all(): array
    {
        return collect(config('driver.all'))
            ->map(fn ($item): array => ['label' => ucfirst((string) $item), 'value' => $item])
            ->toArray();
    }
}
