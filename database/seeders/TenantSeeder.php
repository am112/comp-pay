<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::create([
            'code' => 'MY',
            'label' => 'Malaysia',
            'currency' => 'MYR',
        ]);

        Tenant::create([
            'code' => 'SG',
            'label' => 'Singapore',
            'currency' => 'SGD',
        ]);
    }
}
