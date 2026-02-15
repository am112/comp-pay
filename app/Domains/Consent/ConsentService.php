<?php

namespace App\Domains\Consent;

use App\Data\CreateOrderData;
use App\Models\Integration;

final class ConsentService
{
    public function __construct(
        private ConsentResolver $resolver
    ) {}

    public function create(CreateOrderData $data, Integration $integration): array
    {
        return $this
            ->resolver
            ->resolve($integration->driver)
            ->create($data, $integration);
    }
}
