<?php

namespace App\Actions\Orders;

use App\Actions\Invoices\CreateInvoiceAction;
use App\Data\CreateInvoiceData;
use App\Data\CreateOrderData;
use App\Domains\Consent\Exceptions\ConsentExistException;
use App\Enums\InvoiceTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Models\Integration;
use App\Models\Order;

final class CreateOrderAction
{
    public function handle(CreateOrderData $data, Integration $integration): Order
    {
        $exist = Order::query()
            ->where('reference_no', $data->orderNo)
            ->where('status', OrderStatusEnum::SUCCESS)
            ->exists();
        if ($exist) {
            throw new ConsentExistException('Order exist & completed', $data->orderNo);
        }

        $order = Order::updateOrCreate(
            ['reference_no' => $data->orderNo],
            [
                'amount' => $data->toDatabaseCurrency(),
                'currency' => $integration->tenant->currency,
                'tenant_id' => $integration->tenant_id,
                'driver' => $integration->driver,
                'region' => $integration->tenant->code,
                'status' => OrderStatusEnum::PENDING,
                'total_amount' => $data->toDatabaseCurrency(),
            ]
        );

        $invoice = (new CreateInvoiceAction)->handle($order, CreateInvoiceData::from([
            'orderNo' => $data->orderNo,
            'invoiceNo' => $data->orderNo,
            'amount' => $data->amount,
            'type' => InvoiceTypeEnum::CONSENT,
        ]));

        $order->invoice = $invoice;

        return $order;
    }
}
