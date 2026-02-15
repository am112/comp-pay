<?php

namespace App\Actions\Invoices;

use App\Models\Invoice;

final class GenerateInvoiceReferenceNoAction
{
    public function handle(int $orderId, string $prefix = 'INV'): string
    {
        $sequence = Invoice::query()
            ->where('order_id', $orderId)
            ->lockForUpdate()
            ->count() + 1;

        return sprintf('%s-%04d', $prefix, $sequence);
    }
}
