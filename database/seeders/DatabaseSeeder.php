<?php

namespace Database\Seeders;

use App\Models\landlord\Tenant;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (! Tenant::checkCurrent()) { // Landlord
            $this->runLandlordSeeders();
        } else { // Tenants
            $this->runTenantSeeders();
        }
    }

    public function runLandlordSeeders(): void
    {
        $this->call([
            \Database\Seeders\landlord\PermissionsRolesUsersSeeder::class,
            \Database\Seeders\landlord\TenantSeeder::class,
        ]);
    }

    public function runTenantSeeders(): void
    {
        $this->call([
            \Database\Seeders\tenants\PermissionsRolesUsersSeeder::class,
        ]);
    }
}
