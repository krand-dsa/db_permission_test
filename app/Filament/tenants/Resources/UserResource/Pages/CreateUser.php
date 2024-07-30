<?php

namespace App\Filament\tenants\Resources\UserResource\Pages;

use App\Filament\tenants\Resources\UserResource;
use App\Models\tenants\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Hash::make($data['password']);
        return $data;
    }

}
