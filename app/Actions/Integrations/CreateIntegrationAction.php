<?php

namespace App\Actions\Integrations;

use App\Models\Tenant;

final class CreateIntegrationAction
{
    public function handle(Tenant $tenant, array $data): void
    {
        $tenant->integrations()->create($data);
    }
}
