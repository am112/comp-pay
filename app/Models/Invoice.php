<?php

namespace App\Models;

use App\Enums\InvoiceStatusEnum;
use App\Enums\InvoiceTypeEnum;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'response_at' => 'datetime:Y-m-d',
            'type' => InvoiceTypeEnum::class,
            'status' => InvoiceStatusEnum::class,
        ];
    }

    /* ------------------------
     | Relationships
     |-------------------------*/
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /* ------------------------
     | Query Scopes
     |-------------------------*/
    #[Scope]
    public function byTenant(Builder $query, string $tenantId): Builder
    {
        return $query->where('tenant_id', $tenantId);
    }

    #[Scope]
    public function pending(Builder $query): Builder
    {
        return $query->where('status', InvoiceStatusEnum::PENDING);
    }

    #[Scope]
    public function processing(Builder $query): Builder
    {
        return $query->where('status', InvoiceStatusEnum::PROCESSING);
    }

    #[Scope]
    public function failed(Builder $query): Builder
    {
        return $query->where('status', InvoiceStatusEnum::FAILED);
    }

    /* ------------------------
     | Helpers
     |-------------------------*/
    public function isProcessing(): bool
    {
        return $this->status === InvoiceStatusEnum::PROCESSING;
    }

    public function isPending(): bool
    {
        return $this->status === InvoiceStatusEnum::PENDING;
    }

    public function isFailed(): bool
    {
        return $this->status === InvoiceStatusEnum::FAILED;
    }

    public function isRetryable(): bool
    {
        return in_array($this->status, [
            InvoiceStatusEnum::PENDING,
        ], true);
    }

    /* ------------------------
     | Mutators
     |-------------------------*/

    public function incrementRetry(): void
    {
        $this->increment('retry');
    }

    public function markAsProcessing(string $providerNo)
    {
        $this->update([
            'status' => InvoiceStatusEnum::PROCESSING,
            'provider_no' => $providerNo,
        ]);
    }
}
