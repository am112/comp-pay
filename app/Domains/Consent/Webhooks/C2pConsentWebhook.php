<?php

namespace App\Domains\Consent\Webhooks;

use App\Domains\Consent\ConsentResolver;

final class C2pConsentWebhook
{
    public function handle(array $data): void
    {
        ConsentResolver::resolve(config('driver.connections.c2p.name'))->update($data);
    }
}
