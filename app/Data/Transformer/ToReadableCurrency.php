<?php

namespace App\Data\Transformer;

use Spatie\LaravelData\Transformers\Transformer;

final class ToReadableCurrency implements Transformer
{
    public function transform(\Spatie\LaravelData\Support\DataProperty $property, mixed $value, \Spatie\LaravelData\Support\Transformation\TransformationContext $context): string
    {
        return number_format($value / 100, 2);
    }
}
