<?php

namespace App\Domains\Consent\Webhooks;

use App\Domains\Consent\ConsentResolver;

final class CurlecConsentWebhook
{
    public function handle(array $data): void
    {
        ConsentResolver::resolve(config('driver.connections.curlec.name'))->update($data);
    }
}
