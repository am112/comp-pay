<?php

namespace App\Http\Controllers\Api;

use App\Data\CreateOrderData;
use App\Domains\Consent\ConsentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Consents\StoreConsentRequest;
use Illuminate\Http\JsonResponse;

class ConsentController extends Controller
{
    public function store(StoreConsentRequest $request, ConsentService $service): JsonResponse
    {
        $data = $request->validated();

        $result = $service->create(CreateOrderData::from($data), $request->integration);

        return response()->json([
            'data' => $result,
        ]);
    }
}
