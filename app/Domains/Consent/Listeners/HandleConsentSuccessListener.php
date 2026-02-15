<?php

namespace App\Domains\Consent\Listeners;

use App\Domains\Consent\Events\ConsentSuccessEvent;
use App\Enums\InvoiceStatusEnum;
use App\Enums\OrderStatusEnum;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleConsentSuccessListener implements ShouldQueue
{
    public $afterCommit = true;

    /**
     * Handle the event.
     */
    public function handle(ConsentSuccessEvent $event): void
    {
        $invoice = $event->invoice;

        /** update invoice status */
        $invoice->update([
            'status' => InvoiceStatusEnum::SUCCESS,
            'provider_no' => $event->data['providerNo'],
            'response_code' => $event->data['responseCode'],
            'response_at' => $invoice->response_at ?? now(),
        ]);

        $invoice->order->update([
            'status' => OrderStatusEnum::SUCCESS,
            'provider_no' => $event->data['providerNo'],
        ]);

        /** call integration consent webhook with success data */
    }
}
