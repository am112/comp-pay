<?php

namespace App\Domains\InstantPayment\Drivers;

use App\Data\CreateInvoiceData;
use App\Domains\InstantPayment\Contracts\InstantPaymentContract;
use App\Models\Integration;

final class CurlecInstantPaymentDriver implements InstantPaymentContract
{
    public function get(int $id): void {}

    public function create(CreateInvoiceData $data, Integration $integration): void {}

    public function update(array $data): void {}
}
