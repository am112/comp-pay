<?php

namespace App\Domains\Collection\Contracts;

use App\Data\CreateInvoiceData;
use App\Models\Integration;

interface CollectionContract
{
    public function get(string $id);

    public function create(CreateInvoiceData $data, Integration $integration);

    public function createBatch(array $data, Integration $integration);

    public function update(array $data);
}
