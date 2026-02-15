<?php

namespace App\Http\Controllers\Api;

use App\Data\CreateInvoiceData;
use App\Domains\Collection\CollectionResolver;
use App\Enums\InvoiceTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Collections\StoreCollectionRequest;
use App\Http\Resources\Api\InvoiceResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function show(Request $request, string $invoiceNo): JsonResponse
    {
        $integration = $request->integration;

        $invoice = CollectionResolver::resolve($integration->driver)->get($invoiceNo);

        /** Transform invoice to DTO */
        return response()->json([
            'data' => new InvoiceResource($invoice),
        ]);
    }

    public function store(StoreCollectionRequest $request): JsonResponse
    {
        $data = $request->validated();

        $integration = $request->integration;

        $invoice = CollectionResolver::resolve($integration->driver)->create(CreateInvoiceData::from([...$data, 'type' => InvoiceTypeEnum::COLLECTION]), $integration);

        /** Transform invoice to DTO */
        return response()->json([
            'data' => new InvoiceResource($invoice),
        ]);
    }
}
