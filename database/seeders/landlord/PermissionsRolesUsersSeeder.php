<?php

namespace Database\Seeders\landlord;

use App\Models\landlord\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsRolesUsersSeeder extends Seeder
{
    private $permissions = [];
    private $roles = [];
    /**
     * Run the Permissions / Roles / Users seeds for the Landlord.
     */
    public function run(): void
    {
        $this->seedPermissions();
        $this->seedRoles();
        $this->seedUsers();
    }

    public function seedPermissions(): void
    {
        // Permission Permissions
        $this->permissions['listPermissions'] = Permission::create(['guard_name' => 'landlord', 'name' => 'list.permissions']);
        $this->permissions['createPermissions'] = Permission::create(['guard_name' => 'landlord', 'name' => 'create.permissions']);
        $this->permissions['viewPermissions'] = Permission::create(['guard_name' => 'landlord', 'name' => 'view.permissions']);
        $this->permissions['editPermissions'] = Permission::create(['guard_name' => 'landlord', 'name' => 'edit.permissions']);
        $this->permissions['deletePermissions'] = Permission::create(['guard_name' => 'landlord', 'name' => 'delete.permissions']);

        // Role Permissions
        $this->permissions['listRoles'] = Permission::create(['guard_name' => 'landlord', 'name' => 'list.roles']);
        $this->permissions['createRoles'] = Permission::create(['guard_name' => 'landlord', 'name' => 'create.roles']);
        $this->permissions['viewRoles'] = Permission::create(['guard_name' => 'landlord', 'name' => 'view.roles']);
        $this->permissions['editRoles'] = Permission::create(['guard_name' => 'landlord', 'name' => 'edit.roles']);
        $this->permissions['deleteRoles'] = Permission::create(['guard_name' => 'landlord', 'name' => 'delete.roles']);

        // User Permissions
        $this->permissions['listUsers'] = Permission::create(['guard_name' => 'landlord', 'name' => 'list.users']);
        $this->permissions['createUsers'] = Permission::create(['guard_name' => 'landlord', 'name' => 'create.users']);
        $this->permissions['viewUsers'] = Permission::create(['guard_name' => 'landlord', 'name' => 'view.users']);
        $this->permissions['editUsers'] = Permission::create(['guard_name' => 'landlord', 'name' => 'edit.users']);
        // no delete.users Permission, we do not delete users

        // Tenant Permissions
        $this->permissions['listTenants'] = Permission::create(['guard_name' => 'landlord', 'name' => 'list.tenants']);
        $this->permissions['createTenants'] = Permission::create(['guard_name' => 'landlord', 'name' => 'create.tenants']);
        $this->permissions['viewTenants'] = Permission::create(['guard_name' => 'landlord', 'name' => 'view.tenants']);
        $this->permissions['editTenants'] = Permission::create(['guard_name' => 'landlord', 'name' => 'edit.tenants']);
        $this->permissions['deleteTenants'] = Permission::create(['guard_name' => 'landlord', 'name' => 'delete.tenants']);
    }

    public function seedRoles(): void
    {
        $this->roles['Admin'] = Role::create(['guard_name' => 'landlord', 'name' => 'Admin']);
        // no seeding of permissions for Admin, has all permissions by default

        $this->roles['User'] = Role::create(['guard_name' => 'landlord', 'name' => 'User']);
        $this->roles['User']->givePermissionTo($this->permissions['listUsers']);
        $this->roles['User']->givePermissionTo($this->permissions['listTenants']);
        $this->roles['User']->givePermissionTo($this->permissions['viewTenants']);
    }

    public function seedUsers(): void
    {
        // Development
        if (App::environment('local')) {
            User::factory()->create([
                'name' => 'Tom Test',
                'email' => 'tt@test.test',
                'active' => true,
                'password' => Hash::make('testtest'),
            ])->assignRole($this->roles['Admin']);

            User::factory()->create([
                'name' => 'Active User',
                'email' => 'au@test.test',
                'active' => true,
                'password' => Hash::make('testtest'),
            ])->assignRole($this->roles['User']);

            User::factory()->create([
                'name' => 'Inactive User',
                'email' => 'iu@test.test',
                'active' => false,
                'password' => Hash::make('testtest'),
            ])->assignRole($this->roles['User']);

            User::factory()->create([
                'name' => 'Central User',
                'email' => 'cu@test.test',
                'active' => false,
                'password' => Hash::make('testtest'),
            ])->assignRole($this->roles['User']);
        } elseif (App::environment('prod')) {
            //
        }
    }
}
