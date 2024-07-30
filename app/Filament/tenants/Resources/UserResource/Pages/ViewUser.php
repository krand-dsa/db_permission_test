<?php

namespace App\Filament\tenants\Resources\UserResource\Pages;

use App\Filament\tenants\Resources\UserResource;
use App\Models\tenants\User;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
