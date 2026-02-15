<?php

namespace App\Actions\Integrations;

use App\Models\Integration;

final class UpdateIntegrationAction
{
    public function handle(Integration $integration, array $data): void
    {
        $integration->update($data);
    }
}
