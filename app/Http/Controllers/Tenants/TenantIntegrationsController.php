<?php

namespace App\Http\Controllers\Tenants;

use App\Actions\Integrations\CreateIntegrationAction;
use App\Actions\Integrations\DeleteIntegrationAction;
use App\Actions\Integrations\UpdateIntegrationAction;
use App\Actions\Orders\IntegrationsByTenureQueryBuilderAction;
use App\Data\IntegrationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Integrations\DeleteIntegrationRequest;
use App\Http\Requests\Integrations\StoreIntegrationRequest;
use App\Http\Requests\Integrations\UpdateIntegrationRequest;
use App\Models\Integration;
use App\Models\Tenant;
use App\Services\DriverService;
use App\Services\IntegrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class TenantIntegrationsController extends Controller
{
    public function index(Request $request, Tenant $tenant, IntegrationsByTenureQueryBuilderAction $action): Response
    {
        Gate::authorize('index', Integration::class);

        return Inertia::render('tenants/integrations/integrations-list', [
            'tenant' => $tenant,
            ...$action->handle($request, $tenant),
        ]);
    }

    public function create(Tenant $tenant, DriverService $driverService, IntegrationService $integrationService): Response
    {
        Gate::authorize('create', Integration::class);

        return Inertia::render('tenants/integrations/integrations-create', [
            'tenant' => $tenant,
            'drivers' => $driverService->all(),
            'authenticationKey' => $integrationService->generateAuthenticationKey(),
        ]);
    }

    public function store(StoreIntegrationRequest $request, Tenant $tenant, CreateIntegrationAction $action): RedirectResponse
    {
        Gate::authorize('store', Integration::class);

        $action->handle($tenant, $request->validated());

        return redirect()->route('tenants.applications', ['tenant' => $tenant])->with(['message' => __('Application created')]);
    }

    public function edit(Tenant $tenant, Integration $application, DriverService $driverService, IntegrationService $integrationService): Response
    {
        Gate::authorize('edit', Integration::class);

        return Inertia::render('tenants/integrations/integrations-edit', [
            'tenant' => $tenant,
            'drivers' => $driverService->all(),
            'integration' => IntegrationData::from($application),
            'authenticationKey' => $integrationService->generateAuthenticationKey(),
        ]);
    }

    public function update(UpdateIntegrationRequest $request, Tenant $tenant, Integration $application, UpdateIntegrationAction $action): RedirectResponse
    {
        Gate::authorize('update', Integration::class);

        $action->handle($application, $request->validated());

        return redirect()->route('tenants.applications', ['tenant' => $tenant])->with(['message' => __('Application updated')]);
    }

    public function destroy(DeleteIntegrationRequest $request, Tenant $tenant, Integration $application, DeleteIntegrationAction $action): RedirectResponse
    {
        Gate::authorize('destroy', Integration::class);

        $action->handle($application);

        return redirect()->route('tenants.applications', ['tenant' => $tenant])->with(['message' => __('Application deleted')]);
    }
}
