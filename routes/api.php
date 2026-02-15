<?php

use App\Http\Controllers\Api\CollectionController;
use App\Http\Controllers\Api\ConsentController;
use App\Http\Controllers\Api\StoreBatchCollectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('integrations/consents', [ConsentController::class, 'store'])->middleware('auth.integrations');
Route::post('integrations/collections', [CollectionController::class, 'store'])->middleware('auth.integrations');
Route::get('integrations/collections/{invoiceNo}', [CollectionController::class, 'show'])->middleware('auth.integrations');
Route::post('integrations/collections/batch', StoreBatchCollectionController::class)->middleware('auth.integrations');

/**
 *  integrations/collections - sync
 *  integrations/collections/bulk - jobs
 *  integrations/instants - return url
 */

require __DIR__.'/webhooks.php';
