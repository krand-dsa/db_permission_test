<?php

namespace App\Filament\landlord\Resources\UserResource\Pages;

use App\Filament\landlord\Resources\UserResource;
use App\Models\landlord\User;
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
