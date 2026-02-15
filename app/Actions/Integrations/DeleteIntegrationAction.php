<?php

namespace App\Actions\Integrations;

use App\Models\Integration;

final class DeleteIntegrationAction
{
    public function handle(Integration $integration): void
    {
        $integration->delete();
    }
}
