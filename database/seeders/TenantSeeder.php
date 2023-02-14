<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomTenantModel;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenants = [
            [
                'name'     => 'tenant1',
                'database' => 'spatie-mt-issue-tenant1',
                'domain'   => 'tenant1.laravel-multitenancy-issue.test',
            ],
            [
                'name'     => 'tenant2',
                'database' => 'spatie-mt-issue-tenant2',
                'domain'   => 'tenant2.laravel-multitenancy-issue.test',
            ],
        ];

        collect($tenants)->each(function ($tenant) {
            CustomTenantModel::updateOrCreate([
                'name' => $tenant['name'],
            ], [
                'database' => $tenant['database'],
                'domain'   => $tenant['domain'],
            ]);
        });
    }
}
