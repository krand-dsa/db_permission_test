# db_permission_test
This test project demonstrates the issue that a wrong database is used when checking permissions.

This issue is described in these discussions
* [spatie / laravel-multitenancy](https://github.com/spatie/laravel-multitenancy/discussions/548#discussion-6975570)
* [spatie / laravel-permissions](https://github.com/spatie/laravel-permission/discussions/2699#discussion-6979728)

## Users
* tt@test.test - Admin, granted via Gate::before()
* au@test.test - Active User, has permission to list users via User-role
* iu@test.test - Inactive User, has no access at all
* cu@test.test - Central User, only exists in landlord database to verify which db is used when listing users

all use the password 'testtest'

## Filament
* The Filament panel of the landlord is at [http://localhost/ll](http://localhost/ll)
* The Filament panel of tenant test-1 is at [http://test-1.localhost/](http://test-1.localhost/)

The issue is, that the Active User has the permission to list users in the test-1 tenant db,
but does not get access when logging in the tenant panel. Reason is, that 
HasPermissions::hasPermissionTo('list.users') looks up the landlord permissions table
instead of the tenant permissions table.

## Blade
To demonstrate that it is not a filament issue the same behaviour is shown with
a blade template at [http://test-1.localhost/db-permission-test](http://test-1.localhost/db-permission-test).

## Databases
Migrated and seeded sqlite databases for landlord and tenants are included, because
DB creation for new tenants is not implemented in this test project.

## Cache
* database caching is enabled. All cache entries get stored in the landlord db. 
Unsure if this is as intended. My expectation was that caching takes place at the
respective databases of landlord and tenants. As this is not the case, cache prefixing is enabled.
* It was recognised that calling HasPermissions::hasPermissionTo() creates a tenant_id_1spatie.permission.cache entry
  (with the incorrect landlord permission data), while HasPermissions::getAllPermissions() does not create
a cache entry at all. Unclear if this is as intended.
