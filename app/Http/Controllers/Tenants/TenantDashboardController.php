<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TenantDashboardController extends Controller
{
    public function __invoke(Request $request, Tenant $tenant)
    {
        return Inertia::render('tenants/orders-dashboard', [
            'tenant' => $tenant,
        ]);
    }
}
