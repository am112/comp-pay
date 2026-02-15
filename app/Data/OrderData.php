<?php

namespace App\Data;

use App\Data\Transformer\ToReadableCurrency;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

final class OrderData extends Data
{
    public function __construct(
        public ?int $id,
        public ?string $tenant_id,
        public ?string $reference_no,
        public ?string $provider_no,
        public ?string $status,
        #[WithTransformer(ToReadableCurrency::class)]
        public ?int $amount,
        public ?string $currency,
        public ?int $total_amount,
        public ?int $paid_amount,
        public ?string $driver,
        public ?string $region,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d H:i')]
        public ?Carbon $created_at,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d H:i')]
        public ?Carbon $updated_at,
    ) {}
}
