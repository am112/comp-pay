<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::create(['name' => PermissionsEnum::INTEGRATION_LIST->value]));
        $role->givePermissionTo(Permission::create(['name' => PermissionsEnum::INTEGRATION_SHOW->value]));
        $role->givePermissionTo(Permission::create(['name' => PermissionsEnum::INTEGRATION_CREATE->value]));
        $role->givePermissionTo(Permission::create(['name' => PermissionsEnum::INTEGRATION_EDIT->value]));
        $role->givePermissionTo(Permission::create(['name' => PermissionsEnum::INTEGRATION_UPDATE->value]));
        $role->givePermissionTo(Permission::create(['name' => PermissionsEnum::INTEGRATION_DESTROY->value]));

        $user = User::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );
        $user->assignRole($role);

        $this->call(TenantSeeder::class);

        // $this->call(InvoiceSeeder::class);

        $this->call(IntegrationSeeder::class);
    }
}
