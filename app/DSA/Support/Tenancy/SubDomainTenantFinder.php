<?php
namespace App\DSA\Support\Tenancy;

use App\Models\landlord\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class SubDomainTenantFinder extends TenantFinder
{
    public function findForRequest(Request $request): ?IsTenant {
        $tenant = $this->getTenantNameFromSubdomain($request);
        // Log::debug('SubDomainTenantFinder found: ', [$tenant]);
        return app(IsTenant::class)::whereDomain($tenant)->first();
    }

    /**
     * extracts the tenant name from the host
     * @param  Request  $request
     * @return string|null
     */
    private function getTenantNameFromSubdomain(Request $request): ?string {
        $parts = explode('.', $request->getHost()); // tenant.domain.com
        return $parts[0]; // tenant
    }
}
