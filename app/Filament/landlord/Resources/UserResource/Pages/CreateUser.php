<?php

namespace App\Filament\landlord\Resources\UserResource\Pages;

use App\Filament\landlord\Resources\UserResource;
use App\Models\landlord\User;
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
