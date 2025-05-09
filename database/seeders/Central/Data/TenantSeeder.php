<?php

namespace Database\Seeders\Central\Data;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $tenant = Tenant::firstOrCreate(
                ['id' => 'tenant-' . $i], // kondisi pencarian
                [
                    'name' => 'nikahan - ' . $i,
                ]
            );

            $tenant->domains()->firstOrCreate([
                'domain' => $tenant->id . '.' . config('app.tenancy_domain'),
            ], [
                'tenant_id' => $tenant->id,
            ]);
        }
    }
}
