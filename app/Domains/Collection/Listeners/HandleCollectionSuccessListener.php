<?php

namespace App\Domains\Collection\Listeners;

use App\Domains\Collection\Events\CollectionSuccessEvent;
use App\Enums\InvoiceStatusEnum;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleCollectionSuccessListener implements ShouldQueue
{
    public $afterCommit = true;

    /**
     * Handle the event.
     */
    public function handle(CollectionSuccessEvent $event): void
    {
        $invoice = $event->invoice;

        /** update invoice status */
        $invoice->update([
            'status' => InvoiceStatusEnum::SUCCESS,
            'response_code' => $event->data['responseCode'],
            'response_at' => $invoice->response_at ?? now(),
        ]);

        /** call integration.webhook_collection */
    }
}
