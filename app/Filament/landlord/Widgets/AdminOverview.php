<?php

namespace App\Filament\landlord\Widgets;

use App\Models\landlord\Permission;
use App\Models\landlord\Role;
use App\Models\landlord\Tenant;
use App\Models\landlord\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Mandanten',
                $this->getTenantCount())
                ->icon('heroicon-o-rectangle-stack'),
            Stat::make('Benutzer',
                $this->getAktiveBenutzerCount())
                ->icon('heroicon-o-users')
                ->description('gesamt / aktiv / inaktiv'),
            Stat::make('Rollen', $this->getRollenCount())
                ->icon('heroicon-o-user-group'),
            Stat::make('Berechtigungen', $this->getBerechtigungenCount())
                ->icon('heroicon-o-key'),
        ];
    }

    protected function getTenantCount(): string
    {
        return Tenant::query()->count();
    }

    protected function getAktiveBenutzerCount(): string
    {
        $gesamt = User::query()->count();
        $aktiv = User::query()->where('active', true)->count();
        $inaktiv = User::query()->where('active', false)->count();
        $result = $gesamt . ' / ' . $aktiv . ' / ' . $inaktiv;
        return $result;
    }

    protected function getRollenCount(): int
    {
        return Role::query()->count();
    }

    protected function getBerechtigungenCount(): int
    {
        return Permission::query()->count();
    }
}
