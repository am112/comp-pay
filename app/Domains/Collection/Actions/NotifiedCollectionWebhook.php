<?php

namespace App\Domains\Collection\Actions;

use App\Models\Integration;
use App\Models\Invoice;
use Illuminate\Support\Facades\Http;

final class NotifiedCollectionWebhook
{
    public function handle(Invoice $invoice): void
    {
        $integrations = Integration::query()
            ->where('tenant_id', $invoice->tenant_id)
            ->whereNotNull('webhook_collection')
            ->get();

        foreach ($integrations as $integration) {
            Http::post($integration->webhook_collection, [
                'invoiceId' => $invoice->id,
                'referenceNo' => $invoice->reference_no,
                'provider_no' => $invoice->provider_no,
                'collection_no' => $invoice->collection_no,
                'status' => $invoice->status,
                'amount' => $invoice->amount,
                'currency' => $invoice->currency,
                'batch' => $invoice->batch,
                'retry' => $invoice->retry,
            ]);
        }
    }
}
