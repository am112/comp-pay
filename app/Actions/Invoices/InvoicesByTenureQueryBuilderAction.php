<?php

namespace App\Actions\Invoices;

use App\Data\InvoiceData;
use App\Models\Invoice;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class InvoicesByTenureQueryBuilderAction
{
    public function handle(Request $request, Tenant $tenant): array
    {
        $data = QueryBuilder::for(Invoice::class)
            ->allowedFilters([
                'identifier',
                'reference_no',
                AllowedFilter::callback('date', fn (Builder $builder, $value): Builder => $builder->whereBetween('created_at', $value)),
            ])
            ->when(! $request->filled('filter.date'), fn (Builder $query): Builder => $query->whereBetween('created_at', [now()->subDays(30), now()]))
            ->byTenant($tenant->id)
            ->latest()
            ->get();

        return [
            'invoices' => InvoiceData::collect($data),
        ];
    }
}
