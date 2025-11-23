<?php

namespace App\Domains\Mandate\Webhooks;

use App\Domains\Mandate\MandateResolver;

final class CurlecMandateWebhook
{
    public function __construct() {}

    public function handle(array $data)
    {
        MandateResolver::resolve(config('services.curlec.name'))->update($data);
    }
}
