<?php

namespace App\Data;

use App\Data\Transformer\ToReadableCurrency;
use App\Enums\InvoiceStatusEnum;
use App\Enums\InvoiceTypeEnum;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

final class InvoiceData extends Data
{
    public function __construct(
        public ?int $id,
        public ?string $tenant_id,
        public ?int $order_id,
        #[WithCast(EnumCast::class)]
        public ?InvoiceTypeEnum $type,
        public ?string $collection_no,
        public ?string $reference_no,
        public ?string $provider_no,
        #[WithCast(EnumCast::class)]
        public ?InvoiceStatusEnum $status,
        #[WithTransformer(ToReadableCurrency::class)]
        public ?int $amount,
        public ?string $currency,
        public ?string $driver,
        public ?string $batch,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d H:i')]
        public ?Carbon $created_at,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d H:i')]
        public ?Carbon $updated_at,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d H:i')]
        public ?Carbon $response_at,
    ) {}
}
