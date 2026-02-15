<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

final class MenuData extends Data
{
    public function __construct(public string $title, public string $link, public string $icon) {}

}
