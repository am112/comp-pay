<?php

namespace App\Domains\Collection\Listeners;

use App\Domains\Collection\Events\CollectionSuccessSyncEvent;
use App\Enums\InvoiceStatusEnum;

class HandleCollectionSuccessSyncListener
{
    /**
     * Handle the event.
     */
    public function handle(CollectionSuccessSyncEvent $event): void
    {
        $invoice = $event->invoice;

        /** update invoice status */
        $invoice->update([
            'status' => InvoiceStatusEnum::SUCCESS,
            'response_code' => $event->data['responseCode'],
            'response_at' => $invoice->response_at ?? now(),
        ]);
    }
}
