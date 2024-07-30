<?php

namespace App\Filament\landlord\Resources;

use App\Filament\landlord\Resources\RoleResource\Pages;
use App\Filament\landlord\Resources\RoleResource\RelationManagers;
use App\Models\landlord\Role;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $modelLabel = 'Rolle';
    protected static ?string $pluralModelLabel = 'Rollen';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->minLength(2)
                    ->maxLength(255)
                    ->required()
                    ->unique(ignoreRecord: true),
                Section::make('Berechtigungen')
                    ->description('Folgende Berechtigungen sind verfügbar:')
                    ->schema([
                        CheckboxList::make('Berechtigungen')
                            ->relationship('permissions', 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->orderBy('id'))
                            ->columns(5)
                            ->label('Berechtigungen')
                            ->searchable()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label("registriert am")
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => \App\Filament\landlord\Resources\RoleResource\Pages\ListRoles::route('/'),
            'create' => \App\Filament\landlord\Resources\RoleResource\Pages\CreateRole::route('/create'),
            'view' => \App\Filament\landlord\Resources\RoleResource\Pages\ViewRole::route('/{record}'),
            'edit' => \App\Filament\landlord\Resources\RoleResource\Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
