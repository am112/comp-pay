<?php

namespace App\Domains\InstantPayment\Webhooks;

use App\Domains\InstantPayment\InstantPaymentResolver;

final class C2pInstantPaymentWebhook
{
    public function handle(array $data): void
    {
        InstantPaymentResolver::resolve(config('driver.drivers.c2p.name'))->update($data);
    }
}
