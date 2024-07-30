<?php

namespace App\Models\landlord;

use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Multitenancy\Models\Tenant as SpatieTenant;

class Tenant extends SpatieTenant
{
    use UsesLandlordConnection;

    private string $old_database_name;

    protected static function booted()
    {
        static::creating(function (Tenant $model) {
            $model->setDatabase();
        });
        static::created(function (Tenant $model) {
            $model->createDatabase();
        });
        static::updating(function (Tenant $model) {
            $this->old_database_name = $this->database;
            $model->setDatabase();
        });
        static::updated(function (Tenant $model) {
           $model->moveDatabase();
        });
        static::deleted(function (Tenant $model) {
            $model->deleteDatabase();
        });
    }

    public function setDatabase(): void
    {
        //
    }

    public function createDatabase(): void
    {
        //
    }

    public function moveDatabase(): void
    {
        //
    }

    public function deleteDatabase(): void
    {
        //
    }

    public static function makeDatabaseName(string $name): string
    {
        $dbName = env('DSA_TENANT_DB_PATH') . $name . env('DSA_TENANT_DB_SUFFIX', '.sqlite');
        return $dbName;
    }
}
