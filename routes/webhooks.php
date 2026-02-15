<?php

use App\Domains\Collection\CollectionResolver;
use App\Domains\Consent\ConsentResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::prefix('webhooks')
    ->middleware('webhooks.intercepter')
    ->group(function () {
        /**
         * 1. c2p consent
         * /c2p/consent
         *
         * 2. curlec consent
         * /curlec/consent
         */
        Route::get('test', function () {
            return [
                'message' => 'OK',
            ];
        });

        Route::post('c2p/consent', function (Request $request) {
            Log::info('consent callback data', $request->all());
            ConsentResolver::resolve('c2p')->update($request->all());
        })->name('webhooks.c2p.consent');

        Route::post('c2p/collection', function (Request $request) {
            Log::info('collection callback data', $request->all());
            CollectionResolver::resolve('c2p')->update($request->all());
        })->name('webhooks.c2p.collection');
    });
