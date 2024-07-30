@php use Illuminate\Support\Facades\Auth;use Spatie\Permission\Exceptions\PermissionDoesNotExist; @endphp

<html>
<body>
<h1>Multitenancy / Permissions</h1>
The issue is:
<ul>
    <li>HasPermissions::allPermissions() correctly uses tenant db and <strong>finds the permission to list.users</strong></li>
    <li>HasPermissions::hasPermissionTo() incorrectly uses landlord db and <strong>returns PermissionDoesNotExist</strong>
    because the combination of 'list.users' with guard_name 'tenants' does - of course - not exist in the landlord database</li>
</ul>
This can be demonstrated:
@php
    $hasTenant = \App\Models\landlord\Tenant::current();
    $user = \App\Models\tenants\User::query()->where('name', '=', 'Active User')->first();
    $userConnectionName = $user->getConnectionName();
    $allPermissions = $user->getAllPermissions();
    $hasPermissionToListUsers = '';
    try {
        $hasPermissionToListUsers = $user->hasPermissionTo('list.users');
    } catch (PermissionDoesNotExist $e) {
        $hasPermissionToListUsers = $e->getMessage();
    }

@endphp
<ul>
    <li><strong>We have a Tenant (Tenant::current()):</strong> {{ $hasTenant }}</li>
    <li><strong>We have a user (user->name):</strong> {{ $user->name }}<strong>, with a correct tenant-db-connection (user->getConnectionName()):</strong> {{ $userConnectionName }}</li>
    <li><strong>We receive 'list.users':'tenants' with user->getAllPermissions->pluck('guard_name', 'name'):</strong> {{ $allPermissions->pluck('guard_name', 'name') }}</li>
    <li><strong>We receive a PermissionDoesNotExist exception with user->hasPermissionTo('list.users'):</strong> {{ $hasPermissionToListUsers }}</li>
</ul>
</body>
</html>
