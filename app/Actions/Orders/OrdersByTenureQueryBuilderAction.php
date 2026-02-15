<?php

namespace App\Actions\Orders;

use App\Data\OrderData;
use App\Models\Order;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class OrdersByTenureQueryBuilderAction
{
    public function handle(Request $request, Tenant $tenant): array
    {
        $data = QueryBuilder::for(Order::class)
            ->allowedFilters([
                'identifier',
                'reference_no',
                AllowedFilter::callback('date', fn (Builder $builder, $value): Builder => $builder->whereBetween('created_at', $value)),
            ])
            ->when(! $request->filled('filter.date'), fn (Builder $query): Builder => $query->whereBetween('created_at', [now()->subDays(30), now()]))
            ->byTenant($tenant->id)
            ->latest()
            ->get();

        // dd($data[0]);
        return [
            'orders' => OrderData::collect($data),
        ];
    }
}
