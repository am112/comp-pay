<?php

use App\Domains\Consent\Exceptions\ConsentDriverNotFoundException;
use App\Domains\Consent\Exceptions\ConsentExistException;
use App\Domains\Consent\Exceptions\ConsentProviderException;
use App\Exceptions\InvalidInvoiceStatusException;
use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\IntegrationApiKeyAuth;
use App\Http\Middleware\WebhooksInboundIntercepter;
use App\Services\Exceptions\C2pInvalidResponseException;
use App\Services\Exceptions\C2pRequestFailedException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->appendToGroup('auth.integrations', [
            IntegrationApiKeyAuth::class,
        ]);

        $middleware->appendToGroup('webhooks.intercepter', [
            WebhooksInboundIntercepter::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Driver not found
        $exceptions->render(function (ConsentDriverNotFoundException $e) {
            return response()->json([
                'message' => 'Invalid payment provider.',
            ], 400);
        });

        $exceptions->render(function (ConsentExistException $e) {
            return response()->json([
                'message' => $e->getMessage().': '.$e->providerCode,
            ], 400);
        });

        // Provider error (example)
        $exceptions->render(function (ConsentProviderException $e) {
            return response()->json([
                'message' => 'Payment provider error.',
            ], 422);
        });

        $exceptions->render(function (C2pInvalidResponseException $e) {
            return response()->json([
                'message' => $e->providerCode.': '.$e->getMessage(),
            ], 422);
        });

        $exceptions->render(function (C2pRequestFailedException $e) {
            return response()->json([
                'message' => $e->providerCode.': '.$e->getMessage(),
            ], 422);
        });

        $exceptions->render(function (InvalidInvoiceStatusException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        });

    })->create();
