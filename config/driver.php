<?php

return [

    'all' => [
        'c2p',
        'curlec',
    ],

    'connections' => [
        'c2p' => [
            'name' => 'c2p',
            'key' => '3CAE47F67F6F082C698D3F840148E64BCA519908789EA0B47F84D4AEC7ABAFA6',
            'domain' => 'https://sandbox-pgw.2c2p.com',
            'merchantId' => '702702000004380',
            'encryptionMethod' => 'HS256',
            'quickpay' => [
                'domain' => 'https://demo2.2c2p.com/2C2PFrontEnd/QuickPay/DirectAPI',
            ],

        ],

        'curlec' => [
            'name' => 'curlec',
            'key' => 'curlec-keys',
        ],
    ],

    'consent' => [
        'drivers' => [
            'c2p' => \App\Domains\Consent\Drivers\C2pConsentDriver::class,
            'curlec' => \App\Domains\Consent\Drivers\CurlecConsentDriver::class,
        ],
    ],

    'collection' => [
        'drivers' => [
            'c2p' => \App\Domains\Collection\Drivers\C2pCollectionDriver::class,
            'curlec' => \App\Domains\Collection\Drivers\C2pCollectionDriver::class,
        ],
    ],

    'instant' => [
        'drivers' => [
            'c2p' => \App\Domains\InstantPayment\Drivers\C2pInstantPaymentDriver::class,
            'curlec' => \App\Domains\InstantPayment\Drivers\CurlecInstantPaymentDriver::class,
        ],
    ],
];
