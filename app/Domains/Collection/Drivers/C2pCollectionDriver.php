<?php

namespace App\Domains\Collection\Drivers;

use App\Actions\Invoices\CreateInvoiceAction;
use App\Actions\Invoices\GenerateBatchNoAction;
use App\Data\CreateInvoiceData;
use App\Domains\Collection\Contracts\CollectionContract;
use App\Domains\Collection\Events\CollectionFailedEvent;
use App\Domains\Collection\Events\CollectionSuccessEvent;
use App\Domains\Collection\Events\CollectionSuccessSyncEvent;
use App\Enums\InvoiceStatusEnum;
use App\Enums\InvoiceTypeEnum;
use App\Jobs\Collections\CreateCollectionJob;
use App\Models\Integration;
use App\Models\Invoice;
use App\Models\Order;
use App\Services\C2pApi;
use Illuminate\Support\Facades\DB;

final readonly class C2pCollectionDriver implements CollectionContract
{
    public function __construct(private C2pApi $api, private CreateInvoiceAction $createInvoiceAction) {}

    public function get(string $id)
    {
        $response = $this->api->paymentInquiry($id);

        /** find invoice */
        $invoice = Invoice::query()
            ->with('order')
            ->where('reference_no', $response['invoiceNo'])
            ->firstOrFail();

        $data = [
            'responseCode' => $response['respCode'],
        ];

        if ($invoice->status === InvoiceStatusEnum::PROCESSING) {
            match ($response['respCode']) {
                '0000' => CollectionSuccessSyncEvent::dispatch($invoice, $data),
                default => CollectionFailedEvent::dispatch($invoice, $data),
            };
        }

        return $invoice->fresh();
    }

    public function create(CreateInvoiceData $data, Integration $integration)
    {
        $integration->load('tenant');

        /** find order */
        $order = $this->findOrder($data, $integration);

        /** create invoice */
        $invoice = DB::transaction(function () use ($data, $order) {
            return $this->createInvoiceAction->handle($order, $data);
        });

        /** get payment token from response */
        $token = $this->requestCollectionToken($data, $order, $invoice, $integration);

        /** make payment transaction */
        $this->api->doPayment($token, [
            'customerToken' => $order->provider_no,
        ]);

        /** mark invoice as processing */
        $invoice->markAsProcessing($order->provider_no);

        return $invoice->fresh();
    }

    public function createBatch(array $items, Integration $integration): string
    {
        $batchNo = app(GenerateBatchNoAction::class)->handle();

        collect($items)
            ->groupBy('orderNo')
            ->each(function ($rows) use ($integration, $batchNo) {
                foreach ($rows as $item) {
                    CreateCollectionJob::dispatch(
                        CreateInvoiceData::from([
                            ...$item,
                            'batch' => $batchNo,
                            'type' => InvoiceTypeEnum::COLLECTION,
                        ]),
                        $integration
                    );
                }
            });

        return $batchNo;
    }

    public function update(array $data): void
    {
        /** decode jwt response */
        $response = $this->api->decodeJWTResponse($data['payload']);

        /** find invoice */
        $invoice = Invoice::query()
            ->with('order')
            ->where('reference_no', $response['invoiceNo'])
            ->firstOrFail();

        /**
         * TODO: create a array format
         */
        $data = [
            'responseCode' => $response['respCode'],
        ];

        match ($response['respCode']) {
            '0000' => CollectionSuccessEvent::dispatch($invoice, $data),
            default => CollectionFailedEvent::dispatch($invoice, $data),
        };
    }

    /* ------------------
     | private properties
     |------------------- */

    private function requestCollectionToken(CreateInvoiceData $data, Order $order, Invoice $invoice, Integration $integration)
    {
        /** generate token */
        $response = $this->api->paymentToken([
            'invoiceNo' => $invoice->reference_no,
            'description' => $data->description,
            'amount' => $data->amount,
            'currencyCode' => $integration->tenant->currency,
            'paymentChannel' => ['CC'],
            'customerToken' => [$order->provider_no],
            'request3DS' => 'N',
            'userDefined1' => $order->reference_no,
            'userDefined2' => $data->invoiceNo,
            'backendReturnUrl' => route('webhooks.c2p.collection'),
        ]);

        return $response['paymentToken'];
    }

    private function findOrder(CreateInvoiceData $data, Integration $integration): Order
    {
        return Order::query()
            ->where('reference_no', $data->orderNo)
            ->where('tenant_id', $integration->tenant_id)
            ->whereNotNull('provider_no')
            ->firstOrFail();
    }
}
