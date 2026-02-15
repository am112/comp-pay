<?php

namespace App\Actions\Invoices;

use App\Data\CreateInvoiceData;
use App\Enums\InvoiceStatusEnum;
use App\Exceptions\InvalidInvoiceStatusException;
use App\Models\Invoice;
use App\Models\Order;

final class CreateInvoiceAction
{
    public function handle(Order $order, CreateInvoiceData $data): Invoice
    {
        $invoice = $this->findInvoice($order, $data);

        if ($invoice) {
            if ($invoice->isProcessing()) {
                throw new InvalidInvoiceStatusException('Invoice is in processing state');
            }

            if (! $invoice->isRetryable()) {
                throw new InvalidInvoiceStatusException('Invoice cannot be retried');
            }

            $invoice->update($this->invoicePayload($order, $data));
            $invoice->incrementRetry();

            return $invoice;
        }

        return $order->invoices()->create([
            ...$this->invoicePayload($order, $data),
            'reference_no' => (new GenerateInvoiceReferenceNoAction)
                ->handle($order->id, $data->orderNo),
            'collection_no' => $data->invoiceNo,
            'status' => InvoiceStatusEnum::PENDING,
        ]);
    }

    private function findInvoice(Order $order, CreateInvoiceData $data): ?Invoice
    {
        return $order->invoices()
            ->where('collection_no', $data->invoiceNo)
            ->lockForUpdate() // VERY important for payments
            ->whereIn('status', [InvoiceStatusEnum::PENDING, InvoiceStatusEnum::PROCESSING])
            ->latest()
            ->first();
    }

    private function invoicePayload(Order $order, CreateInvoiceData $data): array
    {
        return [
            'tenant_id' => $order->tenant_id,
            'order_id' => $order->id,
            'type' => $data->type,
            'amount' => $data->toDatabaseAmount(),
            'currency' => $order->currency,
            'driver' => $order->driver,
            'batch' => $data->batch,
        ];
    }
}
