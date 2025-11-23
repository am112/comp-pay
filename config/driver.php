<?php

return [
    'mandate' => [
        'drivers' => [
            'c2p' => \App\Domains\Mandate\Drivers\C2pMandateDriver::class,
            'curlec' => \App\Domains\Mandate\Drivers\CurlecMandateDriver::class,
        ],
    ],
];
