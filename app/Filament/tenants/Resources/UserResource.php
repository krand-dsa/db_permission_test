<?php

namespace App\Filament\tenants\Resources;

use App\DSA\Support\CommonFilamentHelpers;
use App\Filament\tenants\Resources\UserResource\Pages;
use App\Filament\tenants\Resources\UserResource\RelationManagers;
use App\Models\landlord\Tenant;
use App\Models\tenants\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Benutzer';
    protected static ?string $pluralModelLabel = 'Benutzer';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        // Log::debug('UserResource knows Tenant: ', [Tenant::current()]);
        /**
         * Find Permissions that are already set via Roles in order to annotate
         * the Permissions-List accordingly
         */

        $permissionDescripton = array();
        if (!is_null($form->getRecord())) // we handle an existing record, not a new one
        {
            $rolePermissions = parent::getEloquentQuery()
                ->where('id', '=', $form->getRecord()->id)
                ->first()
                ->getPermissionsViaRoles();
            foreach ($rolePermissions as $permission) {
                $permissionDescripton[$permission['id']] = 'über Rolle zugewiesen';
            }
        }

        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('E-Mail')
                    ->email()
                    ->required()
                    ->unique(User::class, ignoreRecord: true)
                    ->maxLength(255),
                Toggle::make('active')
                    ->label('aktiv')
                    ->required()
                    ->rules(['boolean']),
                TextInput::make('password')
                    ->label('Passwort')
                    ->password()
                    ->hidden(function (string $operation) { return $operation != "create"; })
                    ->required()
                    ->string()
                    ->rules(CommonFilamentHelpers::getPasswordRules())
                    ->maxLength(255),
                CheckboxList::make('Rollen')
                    ->relationship('roles', 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->whereNot('name', '=', CommonFilamentHelpers::prohibitMakeRoleAdminByNonAdmins()))
                    ->label('Rollen'),
                Section::make('Berechtigungen')
                    ->description('Alle Berechtigungen. Direkt zugewiesene Berechtigungen sind angehakt. Berechtigungen, die über
                    Rollen zugewiesen wurden, sind kommentiert.')
                    ->schema([
                        CheckboxList::make('Berechtigungen')
                            ->relationship('permissions', 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->orderBy('id'))
                            ->columns(5)
                            ->label('Berechtigungen')
                            ->searchable()
                            ->descriptions($permissionDescripton)
                            ->gridDirection('row')
                    ])
                    ->collapsed()
                    ->hidden(! Auth::user()->hasRole('Admin'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label("E-Mail"),
                Tables\Columns\IconColumn::make('active')
                    ->boolean()
                    ->label("aktiv"),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->label("E-Mail bestätigt")
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('two_factor_confirmed_at')
                    ->dateTime()
                    ->sortable()
                    ->label("2FA bestätigt")
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label("registriert am")
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label("aktualisiert am")
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\tenants\Resources\UserResource\Pages\ListUsers::route('/'),
            'create' => \App\Filament\tenants\Resources\UserResource\Pages\CreateUser::route('/create'),
            'view' => \App\Filament\tenants\Resources\UserResource\Pages\ViewUser::route('/{record}'),
            'edit' => \App\Filament\tenants\Resources\UserResource\Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
