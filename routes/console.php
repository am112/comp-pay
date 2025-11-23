<?php

use App\Data\OrderData;
use App\Domains\Mandate\MandateResolver;
use App\Models\Order;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('mandate:create', function () {
    $order = Order::inRandomOrder()->first();
    dd(OrderData::from($order)->toArray());
    $driver = MandateResolver::resolve($order->driver);
    $this->info($driver->create($order->toArray()));
});
