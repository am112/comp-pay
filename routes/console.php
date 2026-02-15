<?php

use App\Domains\Collection\CollectionResolver;
use App\Domains\Collection\Events\CollectionFailedEvent;
use App\Domains\Collection\Events\CollectionSuccessEvent;
use App\Domains\Consent\ConsentResolver;
use App\Models\Integration;
use App\Models\Invoice;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('collection', function () {
    $this->comment(Inspiring::quote());

    $integration = Integration::find(1);

    CollectionResolver::resolve($integration->driver)->create([
        'orderNo' => 'ORS-0001',
        'invoiceNo' => 'INV-0016',
        'description' => 'Monthly collection',
        'amount' => 30,
    ], $integration);

})->purpose('Display an inspiring quote');

Artisan::command('consent', function () {
    $this->comment(Inspiring::quote());

    $integration = Integration::find(1);

    $url = ConsentResolver::resolve($integration->driver)->create([
        'orderNo' => 'ORT-49905',
        'amount' => 40.00,
    ], $integration);

    dd($url);

})->purpose('Display an inspiring quote');

Artisan::command('batch', function () {
    $integration = Integration::find(2);

    $data = [
        [
            'orderNo' => 'ORS-0001',
            'invoiceNo' => 'INV-0016',
            'description' => 'Monthly collection',
            'amount' => 30,
        ],
        [
            'orderNo' => 'ORS-0002',
            'invoiceNo' => 'INV-0011',
            'description' => 'Monthly collection',
            'amount' => 30,
        ],
        [
            'orderNo' => 'ORS-0003',
            'invoiceNo' => 'INV-0019',
            'description' => 'Monthly collection',
            'amount' => 30,
        ],
    ];

    $batch = CollectionResolver::resolve('c2p')->createBatch($data, $integration);
    dd($batch);
});

Artisan::command('check', function () {
    $response = CollectionResolver::resolve('c2p')->get('INV-0019-0006');

    /** find invoice */
    $invoice = Invoice::query()
        ->with('order')
        ->where('reference_no', $response['invoiceNo'])
        ->firstOrFail();

    if ($response['respCode'] !== '0000') {
        /** notify collection failed */
        CollectionFailedEvent::dispatch($invoice, []);

        return;
    }

    /** notify consent success */
    CollectionSuccessEvent::dispatch($invoice, [
        'responseCode' => $response['respCode'],
    ]);
});
