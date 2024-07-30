<?php

namespace App\Policies\tenants;

use App\Models\landlord\Tenant;
// use Spatie\Permission\Models\Permission;
use App\Models\tenants\Permission;
use App\Models\tenants\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

use function Psy\debug;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //Log::debug('UserPolicy knows Tenant: ', [Tenant::current()]);
        /*
        Log::debug('user->can returns: ', [$user->can('list.users', ['tenants'])]);
        Log::debug('User is: ', [$user]);
        Log::debug('User has getAllPermissions: ', [$user->getAllPermissions()]);
        // Log::debug('Permission list.users', [Permission::findById(21)]);
        // Permission::create(['guard_name' => 'tenants', 'name' => 'list.users']);
        Log::debug('user->hasPermissionTo list.users returns: ', [$user->hasPermissionTo('list.users')]);
        */
        return $user->can('list.users');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->can('view.users');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.users');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->can('edit.users');
    }

    public function deleteAny(User $user, User $model): bool
    {
        return false; // we do not delete users
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return false; // we do not delete users
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false; // we do not delete users
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false; // we do not delete users
    }
}
