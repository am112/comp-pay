<?php

namespace App\Actions\Invoices;

use Illuminate\Support\Str;

final class GenerateBatchNoAction
{
    public function handle(): string
    {
        return now()->format('YmdHis').Str::upper(Str::random(6));
    }
}
