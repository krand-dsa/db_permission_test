<?php

namespace App\Models\landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Permission\Models\Role as ModelsRole;

/**
 * implementation in Spatie Permissions - nothing necessary here
 * Model exists in order to permit for Model Policy to be used
 */
class Role extends ModelsRole
{
    use HasFactory, UsesLandlordConnection;
}
