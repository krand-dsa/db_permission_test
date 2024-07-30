<?php

namespace App\DSA\Support\Tenancy;

use App\Exceptions\TenantAccessToLandlord;
use App\Models\landlord\Tenant;
use Closure;

class ProhibitTenantAccessMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Tenant::checkCurrent()) { // a tenant is set, but we expect a landlord
            return $this->handleInvalidRequest();
        }

        return $next($request);
    }

    public function handleInvalidRequest()
    {
        throw TenantAccessToLandlord::make();
    }
}
