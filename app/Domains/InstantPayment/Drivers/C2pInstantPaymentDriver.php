<?php

namespace App\Domains\InstantPayment\Drivers;

use App\Actions\Invoices\GenerateInvoiceReferenceNoAction;
use App\Data\CreateInvoiceData;
use App\Domains\InstantPayment\Contracts\InstantPaymentContract;
use App\Enums\InvoiceStatusEnum;
use App\Enums\InvoiceTypeEnum;
use App\Models\Integration;
use App\Models\Invoice;
use App\Models\Order;
use App\Services\C2pApi;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final readonly class C2pInstantPaymentDriver implements InstantPaymentContract
{
    private C2pApi $api;

    public function __construct()
    {
        $this->api = new C2pApi;
    }

    public function get(int $id): void {}

    public function create(CreateInvoiceData $data, Integration $integration): string
    {
        try {
            DB::beginTransaction();

            $integration->load('tenant');

            /** find order */
            $order = Order::query()
                ->where('reference_no', $data->orderNo)
                ->where('tenant_id', $integration->tenant_id)
                ->firstOrFail();

            /** create an invoice */
            $invoice = Invoice::create(
                [
                    'reference_no' => (new GenerateInvoiceReferenceNoAction)->handle($order->id, $data->invoiceNo),
                    'tenant_id' => $integration->tenant_id,
                    'order_id' => $order->id,
                    'type' => InvoiceTypeEnum::INSTANT,
                    'collection_no' => $data->invoiceNo,
                    'provider_no' => $order->provider_no,
                    'status' => InvoiceStatusEnum::PENDING,
                    'amount' => $data->toDatabaseAmount(),
                    'currency' => $order->currency,
                    'driver' => $order->driver,
                ]);

            /** call c2p api to generate link */
            $link = $this->api->quickpay([]);

            DB::commit();

            return $link;

        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage(), $exception->getTrace());
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function update(array $data): void {}
}
