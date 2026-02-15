<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return Inertia::render('dashboard', [
            'tenants' => Tenant::all(),
        ]);
    }
}
