<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tenant = Tenant::inRandomOrder()->first();

        return [
            'tenant_id' => $tenant->id,
            'reference_no' => 'OR-'.$this->faker->unique()->numberBetween(100000, 999999),
            'provider_no' => $this->faker->unique()->numberBetween(100000, 999999),
            'status' => 'pending',
            'amount' => $this->faker->numberBetween(5000, 9999),
            'currency' => $tenant->currency,
            'driver' => $this->faker->randomElement(['c2p', 'curlec']),
            'region' => $tenant->code,
        ];
    }
}
