<?php

namespace App\Data;

use App\Enums\InvoiceTypeEnum;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

final class CreateInvoiceData extends Data
{
    public function __construct(
        public string $orderNo,
        public ?string $invoiceNo,
        public ?string $description,
        public float $amount,
        public ?string $batch,
        #[WithCast(EnumCast::class)]
        public ?InvoiceTypeEnum $type,
    ) {}

    public function toDatabaseAmount(): int
    {
        return $this->amount * 100;
    }
}
