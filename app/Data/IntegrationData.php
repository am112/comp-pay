<?php

declare(strict_types=1);

namespace App\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

final class IntegrationData extends Data
{
    public function __construct(
        public ?int $id,
        public ?string $tenant_id,
        public string $name,
        public string $status,
        public string $driver,
        public ?string $redirect_consent,
        public ?string $redirect_collection,
        public ?string $webhook_consent,
        public ?string $webhook_collection,
        public ?string $authentication_key,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d H:i')]
        public ?Carbon $created_at,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d H:i')]
        public ?Carbon $updated_at,
    ) {}

}
