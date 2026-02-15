<?php

namespace App\Http\Controllers\Tenants;

use App\Actions\Orders\OrdersByTenureQueryBuilderAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TenantOrdersController extends Controller
{
    public function index(Request $request, Tenant $tenant, OrdersByTenureQueryBuilderAction $action)
    {
        return Inertia::render('tenants/orders-list', [
            'tenant' => $tenant,
            ...$action->handle($request, $tenant),
        ]);
    }
}
