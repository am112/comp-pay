<?php

namespace App\Domains\Mandate\Webhooks;

use App\Domains\Mandate\MandateResolver;

final class C2pMandateWebhook
{
    public function __construct() {}

    public function handle(array $data)
    {
        MandateResolver::resolve(config('services.c2p.name'))->update($data);
    }
}
