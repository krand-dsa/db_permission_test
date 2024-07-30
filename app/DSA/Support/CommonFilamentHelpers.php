<?php

namespace App\DSA\Support;

//use App\Models\landlord\Tenant;
use http\Env\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Multitenancy\Models\Tenant;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class CommonFilamentHelpers
{
    public static function getPasswordRules(): array
    {
        if (App::environment('local') ||
            App::environment('dev')) $rules = Password::min(8);
        else $rules = Password::min(10) // prod
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols();
        return [$rules];
    }

    public static function prohibitMakeRoleAdminByNonAdmins(): string
    {
        if (! Auth::user()->hasRole('Admin')) {
            return 'Admin';
        } else return '';
    }
}
