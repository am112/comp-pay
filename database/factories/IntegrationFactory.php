<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Integration>
 */
class IntegrationFactory extends Factory
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
            'name' => fake()->streetName(),
            'status' => 'active',
            'driver' => fake()->randomElement(['c2p', 'curlec']),
            'authentication_key' => sha1(fake()->bothify('##??#?##?##??')),
        ];
    }
}
