<?php

namespace App\Domains\Consent\Drivers;

use App\Actions\Orders\CreateOrderAction;
use App\Data\CreateOrderData;
use App\Domains\Consent\Contracts\ConsentContract;
use App\Domains\Consent\Events\ConsentFailedEvent;
use App\Domains\Consent\Events\ConsentSuccessEvent;
use App\Domains\Consent\Exceptions\ConsentProviderException;
use App\Models\Integration;
use App\Models\Invoice;
use App\Services\C2pApi;
use Illuminate\Support\Facades\DB;

final readonly class C2pConsentDriver implements ConsentContract
{
    public function __construct(private C2pApi $api, private CreateOrderAction $createOrderAction) {}

    public function get(string $id): array
    {
        return $this->api->paymentInquiry($id);
    }

    public function create(CreateOrderData $data, Integration $integration)
    {
        return DB::transaction(function () use ($data, $integration): array {
            $order = $this->createOrderAction->handle($data, $integration);

            $integration->load('tenant');

            $response = $this->requestConsentToken($order, $data, $integration);

            return [
                'orderNo' => $order->reference_no,
                'invoiceNo' => $order->invoice->reference_no,
                'authorizeLink' => $response['webPaymentUrl'],
            ];
        });
    }

    public function update(array $data): void
    {
        DB::transaction(function () use ($data) {
            $response = $this->api->decodeJWTResponse($data['payload']);

            $invoice = Invoice::query()
                ->with('order')
                ->where('collection_no', $response['userDefined1'])
                ->firstOrFail();

            if ($response['respCode'] !== '0000') {
                ConsentFailedEvent::dispatch($invoice, [
                    'responseCode' => $response['respCode'],
                    'responseDescription' => $response['respDesc'],
                ]);

                return;
            }

            ConsentSuccessEvent::dispatch($invoice, [
                'responseCode' => '0000',
                'providerNo' => $response['customerToken'],
            ]);
        });
    }

    /* ------------------
     | private properties
     |------------------- */

    private function requestConsentToken($order, CreateOrderData $data, Integration $integration): array
    {
        $response = $this->api->paymentToken([
            'invoiceNo' => $order->invoice->reference_no,
            'description' => $data->description ?? __('Consent and First Month'),
            'amount' => $data->amount,
            'currencyCode' => $integration->tenant->currency,
            'tokenize' => true,
            'paymentChannel' => ['CC'],
            'frontendReturnUrl' => route('integrations.c2p.consent.redirect'),
            'backendReturnUrl' => route('webhooks.c2p.consent'),
            'userDefined1' => $data->orderNo,
        ]);

        if ($response['respCode'] !== '0000') {
            throw new ConsentProviderException(
                'C2P consent failed',
                $response['respCode']
            );
        }

        return $response;
    }
}
