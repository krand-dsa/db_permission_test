<?php

namespace App\Providers;

use App\Models\landlord\Tenant;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Admin') ? true : null;
        });


        if (! Tenant::checkCurrent()) { // landlord connection
            Gate::policy(\App\Models\landlord\User::class, \App\Policies\landlord\UserPolicy::class);
            Gate::policy(\App\Models\landlord\Tenant::class, \App\Policies\landlord\TenantPolicy::class);
            Gate::policy(\App\Models\landlord\Permission::class, \App\Policies\landlord\PermissionPolicy::class);
            Gate::policy(\App\Models\landlord\Role::class, \App\Policies\landlord\RolePolicy::class);
        } else { // tenant connection
            Gate::policy(\App\Models\tenants\User::class, \App\Policies\tenants\UserPolicy::class);
            Gate::policy(\App\Models\tenants\Permission::class, \App\Policies\tenants\PermissionPolicy::class);
            Gate::policy(\App\Models\tenants\Role::class, \App\Policies\tenants\RolePolicy::class);
        }
    }
}
