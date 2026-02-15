<?php

namespace App\Actions\Integrations;

use App\Data\IntegrationData;
use App\Models\Integration;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class IntegrationsByTenureQueryBuilderAction
{
    public function handle(Request $request, Tenant $tenant): array
    {
        $data = QueryBuilder::for(Integration::class)
            ->allowedFilters([
                'name',
                'status',
                'driver',
                AllowedFilter::callback('date', fn (Builder $builder, $value): Builder => $builder->whereBetween('created_at', $value)),
            ])
            ->byTenant($tenant->id)
            ->latest()
            ->get();

        return [
            'integrations' => IntegrationData::collect($data),
        ];
    }
}
