<?php

namespace Database\Factories;

use App\Enums\InvoiceStatusEnum;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $identifier = $this->faker->unique()->numberBetween(100000, 999999);
        $driver = $this->faker->randomElement(['c2p', 'curlec']);
        $amount = $this->faker->numberBetween(5000, 9999);

        // Create the order first
        $order = Order::factory()->create([
            'provider_no' => $identifier,
            'driver' => $driver,
            'amount' => $amount,
        ]);

        return [
            'tenant_id' => $order->tenant_id,
            'type' => 'consent',
            'collection_no' => $order->reference_no,
            'reference_no' => 'INV-'.fake()->unique()->bothify('######'),
            'provider_no' => $identifier,
            'status' => InvoiceStatusEnum::PENDING,
            'amount' => $amount,
            'currency' => $order->currency,
            'driver' => $driver,
            'response_at' => $this->faker->dateTimeBetween('now', '+1 year'),
            'order_id' => $order->id,
        ];
    }
}
