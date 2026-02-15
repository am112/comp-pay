<?php

namespace App\Domains\Consent\Drivers;

use App\Data\CreateOrderData;
use App\Domains\Consent\Contracts\ConsentContract;
use App\Models\Integration;

final class CurlecConsentDriver implements ConsentContract
{
    public function get(string $id): string
    {
        /** find consent by id and return it */
        return $id;
    }

    public function create(CreateOrderData $data, Integration $integration)
    {
        /** call payment providers to generate link */
        return 'curlec payment link';
    }

    public function update(array $data): void
    {
        /** update consent here */
    }
}
