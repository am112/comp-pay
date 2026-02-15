<?php

namespace App\Domains\Collection\Listeners;

use App\Domains\Collection\Events\CollectionFailedEvent;
use App\Domains\Collection\Events\CollectionFailedSyncEvent;
use App\Enums\InvoiceStatusEnum;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleCollectionFailedSyncListener implements ShouldQueue
{
    public $afterCommit = true;

    /**
     * Handle the event.
     */
    public function handle(CollectionFailedSyncEvent $event): void
    {
        logger('update collection failed listener');

        $invoice = $event->invoice;

        $invoice->update([
            'status' => InvoiceStatusEnum::FAILED,
            'response_at' => now(),
            'response_code' => $event->data['responseCode'],
        ]);

        /** call integration.webhook_collection */
    }
}
