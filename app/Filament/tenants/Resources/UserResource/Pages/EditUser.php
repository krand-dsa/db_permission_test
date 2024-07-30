<?php

namespace App\Filament\tenants\Resources\UserResource\Pages;

use App\Filament\tenants\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            // Actions\DeleteAction::make(), // we do not delete users
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['password'])) $data['password'] = Hash::make($data['password']);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
