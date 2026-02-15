<?php

declare(strict_types=1);

namespace App\Actions\Menu;

use App\Data\MenuData;

final readonly class ListMenuAction
{
    public function handle(string $tenantId): array
    {
        return [
            [
                'title' => '',
                'items' => [
                    new MenuData('Dashboard', route('tenants.dashboard', ['tenant' => $tenantId], absolute: false), 'LayoutGrid'),
                ],
            ],
            [
                'title' => 'Payments Management',
                'items' => [
                    new MenuData('Orders', route('tenants.orders', ['tenant' => $tenantId], absolute: false), 'ShoppingBag'),
                    new MenuData('Invoices', route('tenants.invoices', ['tenant' => $tenantId], absolute: false), 'FilePenLine'),
                ],
            ],
            [
                'title' => 'Administration',
                'items' => [
                    new MenuData('Applications', route('tenants.applications', ['tenant' => $tenantId], absolute: false), 'Handshake'),
                ],
            ],
        ];
    }
}
