<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Tenants\TenantDashboardController;
use App\Http\Controllers\Tenants\TenantIntegrationsController;
use App\Http\Controllers\Tenants\TenantInvoicesController;
use App\Http\Controllers\Tenants\TenantOrdersController;
use App\Services\C2pApi;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::prefix('tenants/{tenant}')->group(function () {
        Route::get('/dashboard', TenantDashboardController::class)->name('tenants.dashboard');
        Route::get('/orders', [TenantOrdersController::class, 'index'])->name('tenants.orders');
        Route::get('/invoices', [TenantInvoicesController::class, 'index'])->name('tenants.invoices');

        Route::resource('/applications', TenantIntegrationsController::class)->except('show')->names([
            'index' => 'tenants.applications',
            'create' => 'tenants.applications.create',
            'store' => 'tenants.applications.store',
            'edit' => 'tenants.applications.edit',
            'update' => 'tenants.applications.update',
            'destroy' => 'tenants.applications.destroy',
        ]);
    });
});

require __DIR__.'/settings.php';

Route::post('c2p/consent/redirect', function (Request $request) {
    $data = json_decode(base64_decode($request->paymentResponse), true);
    $response = (new C2pApi)->paymentInquiry($data['invoiceNo']);

    return $response;
})->withoutMiddleware([VerifyCsrfToken::class])->name('integrations.c2p.consent.redirect');
