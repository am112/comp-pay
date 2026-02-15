<?php

namespace App\Http\Controllers\Tenants;

use App\Actions\Orders\InvoicesByTenureQueryBuilderAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TenantInvoicesController extends Controller
{
    public function index(Request $request, Tenant $tenant, InvoicesByTenureQueryBuilderAction $action)
    {
        return Inertia::render('tenants/invoices-list', [
            'tenant' => $tenant,
            ...$action->handle($request, $tenant),
        ]);
    }
}
