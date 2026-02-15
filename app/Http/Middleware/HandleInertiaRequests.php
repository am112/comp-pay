<?php

namespace App\Http\Middleware;

use App\Actions\Menu\ListMenuAction;
use App\Models\Tenant;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        $singleTenant = $request->route('tenant') ?? null;

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim((string) $message), 'author' => trim((string) $author)],
            'auth' => [
                'user' => $request->user(),
            ],
            'tenant' => $singleTenant,
            'tenants' => $singleTenant === null ? Tenant::all() : [],
            'menu' => $this->getMenuByTenant($request->route('tenant')?->id ?? null),
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
            ],
        ];
    }

    private function getMenuByTenant(?string $tenantId): array
    {
        if ($tenantId === null) {
            return [];
        }

        return (new ListMenuAction)->handle($tenantId);
    }
}
