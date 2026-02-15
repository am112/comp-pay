<?php

namespace App\Domains\Consent\Listeners;

use App\Domains\Consent\Events\ConsentFailedEvent;
use App\Enums\InvoiceStatusEnum;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleConsentFailedListener implements ShouldQueue
{
    public $afterCommit = true;

    /**
     * Handle the event.
     */
    public function handle(ConsentFailedEvent $event): void
    {
        $invoice = $event->invoice;

        $invoice->update([
            'status' => InvoiceStatusEnum::FAILED,
            'response_at' => now(),
            'response_code' => $event->data['responseCode'],
        ]);

        logger('update consent failed listener', $invoice->toArray());
    }
}
