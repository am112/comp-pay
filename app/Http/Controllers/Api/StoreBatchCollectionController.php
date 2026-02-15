<?php

namespace App\Http\Controllers\Api;

use App\Domains\Collection\CollectionResolver;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Collections\StoreBatchCollectionRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class StoreBatchCollectionController extends Controller
{
    public function __invoke(StoreBatchCollectionRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $integration = $request->integration;

            $url = CollectionResolver::resolve($integration->driver)->createBatch($data, $integration);

            return response()->json([
                'data' => $url,
            ]);
        } catch (Exception $exception) {
            Log::error('Collection Controller '.$exception->getMessage());

            return response()->json([
                'message' => 'Something when wrong! '.$exception->getMessage(),
            ], 400);
        }
    }
}
