<?php

namespace App\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

final class OrderData extends Data
{
    public function __construct(
        public ?int $id,
        public string $reference_no,
        public string $identifier,
        public string $status,
        public ?int $amount,
        public ?int $total_amount,
        public ?int $paid_amount,
        public ?string $driver,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d H:i')]
        public ?Carbon $created_at,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d H:i')]
        public ?Carbon $updated_at,
    ) {}
}
