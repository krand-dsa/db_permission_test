<?php

namespace App\Exceptions;

use Exception;

class TenantAccessToLandlord extends Exception
{
    public static function make()
    {
        return new static('The request expected the landlord but a tenant was set.');
    }
}
