<?php

namespace App\Domains\InstantPayment\Contracts;

use App\Data\CreateInvoiceData;
use App\Models\Integration;

interface InstantPaymentContract
{
    public function get(int $id);

    public function create(CreateInvoiceData $data, Integration $integration);

    public function update(array $data);
}
