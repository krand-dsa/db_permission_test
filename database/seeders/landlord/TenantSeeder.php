<?php

namespace Database\Seeders\landlord;

use App\Models\landlord\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (App::environment('local')) {
            DB::table('tenants')->insert([
                'name' => 'test-1',
                'domain' => 'test-1',
                'database' => Tenant::makeDatabaseName('test-1'),
            ]);
            DB::table('tenants')->insert([
                'name' => 'test-2',
                'domain' => 'test-2',
                'database' => Tenant::makeDatabaseName('test-2'),
            ]);
        } elseif (App::environment('prod')) {
            //
        }
    }
}
