<?php

namespace App\Domains\InstantPayment\Webhooks;

use App\Domains\InstantPayment\InstantPaymentResolver;

final class CurlecInstantPaymentWebhook
{
    public function handle(array $data): void
    {
        InstantPaymentResolver::resolve(config('driver.drivers.curlec.name'))->update($data);
    }
}
