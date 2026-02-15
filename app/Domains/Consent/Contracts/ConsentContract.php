<?php

namespace App\Domains\Consent\Contracts;

use App\Data\CreateOrderData;
use App\Models\Integration;

interface ConsentContract
{
    public function get(string $id);

    public function create(CreateOrderData $data, Integration $integration);

    public function update(array $data);
}
