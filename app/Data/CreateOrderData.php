<?php

namespace App\Data;

use Spatie\LaravelData\Data;

final class CreateOrderData extends Data
{
    public function __construct(
        public string $orderNo,
        public ?string $description,
        public float $amount,
        public ?string $currency,
        public ?string $region,
    ) {}

    public function toDatabaseCurrency(): int
    {
        return $this->amount * 100;
    }
}
