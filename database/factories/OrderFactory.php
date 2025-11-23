<?php

namespace Database\Factories;

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
        return [
            'reference_no' => $this->faker->unique()->uuid(),
            'identifier' => $this->faker->unique()->uuid(),
            'status' => 'pending',
            'amount' => $this->faker->numberBetween(5000, 9999),
            'driver' => $this->faker->randomElement(['c2p', 'curlec']),
            'region' => $this->faker->randomElement(['MY', 'SG']),
        ];
    }
}
