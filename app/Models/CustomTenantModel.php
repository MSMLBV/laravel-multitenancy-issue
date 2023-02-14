<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;

class CustomTenantModel extends Tenant
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tenants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'domain',
        'database',
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(fn (CustomTenantModel $model) => $model->createDatabase());
    }

    /**
     * Create a new database for a freshly created tenant.
     *
     * @return void
     */
    public function createDatabase(): void
    {
        $databaseName = $this->database;
        $hasDb = DB::connection('landlord')
            ->select('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ' . "'" . $databaseName . "'");

        if (empty($hasDb)) {
            DB::connection('landlord')->statement("CREATE DATABASE `{$databaseName}`");
        }
    }
}
