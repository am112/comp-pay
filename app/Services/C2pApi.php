<?php

namespace App\Services;

use App\Services\Exceptions\C2pInvalidResponseException;

class C2pApi
{
    use C2pHasher;

    private readonly string $domain;

    private readonly string $apiKey;

    private readonly string $merchantId;

    private readonly string $encryptionMethod;

    private readonly C2pClient $client;

    private readonly C2pJwt $jwt;

    public function __construct()
    {
        /** move to env */
        $this->domain = config('driver.connections.c2p.domain');
        $this->apiKey = config('driver.connections.c2p.key');
        $this->merchantId = config('driver.connections.c2p.merchantId');
        $this->encryptionMethod = config('driver.connections.c2p.encryptionMethod');

        $this->client = new C2pClient($this->domain);
        $this->jwt = new C2pJwt($this->apiKey, $this->encryptionMethod);
    }

    public function paymentToken(array $params): array
    {
        $url = '/payment/4.3/paymentToken';

        $payload = [
            'merchantID' => $this->merchantId,
            ...$params,
        ];

        $response = $this->client->post($url, [
            'payload' => $this->jwt->encode($payload),
        ]);

        if (isset($response['respCode']) && $response['respCode'] !== '0000') {
            throw new C2pInvalidResponseException(
                $response['respDesc'] ?? 'Invalid response',
                $response['respCode'] ?? null
            );
        }

        $result = $this->jwt->decode($response['payload']);

        if (($result['respCode'] ?? null) !== '0000') {
            throw new C2pInvalidResponseException(
                $result['respDesc'] ?? 'Invalid response',
                $result['respCode'] ?? null
            );
        }

        return (array) $result;
    }

    public function decodeJWTResponse(string $encodedRequest): array
    {
        $response = $this->jwt->decode($encodedRequest);

        return (array) $response;
    }

    public function paymentInquiry(string $invoiceNo, string $locale = 'EN'): array
    {
        $url = '/payment/4.3/paymentInquiry';

        $payload = [
            'merchantID' => $this->merchantId,
            'invoiceNo' => $invoiceNo,
            'locale' => $locale,
        ];

        $response = $this->client->post($url, [
            'payload' => $this->jwt->encode($payload),
        ]);

        return $this->jwt->decode($response['payload']);
    }

    public function doPayment(string $paymentToken, array $data): ?array
    {
        $url = '/payment/4.3/payment';

        $payload = [
            'paymentToken' => $paymentToken,
            'locale' => 'en',
            'payment' => [
                'code' => [
                    'channelCode' => 'CC',
                ],
                'data' => $data,
            ],
        ];

        $response = $this->client->post($url, $payload);

        if ($response['respCode'] != '2000') {
            throw new C2pInvalidResponseException(
                $response['respDesc'] ?? 'Invalid response',
                $response['respCode'] ?? null
            );
        }

        return (array) $response;
    }

    public function quickpay(array $data): mixed
    {

        $payload = [
            'GenerateQPReq' => [
                'version' => '2.4',
                'timeStamp' => now()->format('YmdHis'),
                'merchantID' => $this->merchantId,
                'orderIdPrefix' => $data['invoiceNo'],
                'description' => $data['description'],
                'currency' => $data['currency'],
                'amount' => $data['amount'],
                'expiry' => $data['expiry'], // now()->addYear()->format('Y-m-d H:i:s'),
                'userData1' => $data['orderNo'],
                'resultUrl1' => $data['redirectUrl'],
                'resultUrl2' => $data['webhookUrl'],
            ],
        ];

        $payload['GenerateQPReq']['hashValue'] = $this->generate2C2PHash($payload['GenerateQPReq']);

        $encodedPayload = base64_encode(json_encode($payload));

        $this->client = new C2pClient(config('driver.connections.c2p.quickpay.domain'));
        $response = $this->client->post('', ['body' => $encodedPayload], ['Content-Type' => 'text/plain']);

        return json_decode(base64_decode($response), false);

    }
}
