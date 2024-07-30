<?php

namespace App\Filament\tenants\Resources\UserResource\Pages;

use App\Filament\tenants\Resources\UserResource;
use App\Models\tenants\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs():array
    {
        return [
            'alle' => Tab::make("Alle Benutzer")
                ->badge(User::query()->count()),
            'aktiv' => Tab::make("Aktive Benutzer")
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', true))
                ->badge(User::query()->where('active', true)->count()),
            'inaktiv' => Tab::make("Inaktive Benutzer")
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', false))
                ->badge(User::query()->where('active', false)->count()),
        ];
    }
}
