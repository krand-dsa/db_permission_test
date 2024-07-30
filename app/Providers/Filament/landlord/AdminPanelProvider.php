<?php

namespace App\Providers\Filament\landlord;

use App\DSA\Support\CommonFilamentHelpers;
use App\DSA\Support\Tenancy\ProhibitTenantAccessMiddleware;
use App\Filament\landlord\Widgets\AdminOverview;
use Filament\FontProviders\LocalFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public $tenant = null;
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('ll') // landlord
            ->login()
            ->passwordReset()
            ->profile()
            ->colors([Color::Amber])
            ->font('Inter', asset('css/Inter-VariableFont_slnt,wght.ttf'),LocalFontProvider::class)
            ->discoverResources(in: app_path('Filament/landlord/Resources'), for: 'App\\Filament\\landlord\\Resources')
            ->discoverPages(in: app_path('Filament/landlord/Pages'), for: 'App\\Filament\\landlord\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/landlord/Widgets'), for: 'App\\Filament\\landlord\\Widgets')
            ->widgets([
                AdminOverview::class
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authGuard('landlord')
            ->middleware([
                ProhibitTenantAccessMiddleware::class,
            ], true);
    }
}
