<?php

namespace Database\Factories;

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
        $identifier = $this->faker->uuid(); // no unique() needed
        $driver = $this->faker->randomElement(['c2p', 'curlec']);
        $amount = $this->faker->numberBetween(5000, 9999);

        // Create the order first
        $order = Order::factory()->create([
            'identifier' => $identifier,
            'driver' => $driver,
            'amount' => $amount,
        ]);

        return [
            'type' => 'mandate',
            'collection_no' => 'OR-'.time().mb_str_pad(mt_rand(1, 9999).'', 4, '0', STR_PAD_LEFT),
            'reference_no' => $this->faker->uuid(),
            'identifier' => $identifier,
            'status' => 'pending',
            'amount' => $amount,
            'driver' => $driver,
            'response_at' => $this->faker->dateTimeBetween('now', '+1 year'),
            'order_id' => $order->id,
        ];
    }
}
