<?php

namespace App\Filament\landlord\Resources;

use App\Filament\landlord\Resources\TenantResource\Pages;
use App\Filament\landlord\Resources\TenantResource\RelationManagers;
use App\Models\landlord\Tenant;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'Mandanten';
    protected static ?string $modelLabel = 'Mandant';
    protected static ?string $pluralModelLabel = 'Mandanten';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('domain')
                    ->required()
                    ->maxLength(255),
                TextInput::make('database')
                    ->label('Datenbank')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('domain')
                    ->label('Domain')
                    ->searchable(),
                TextColumn::make('database')
                    ->label('Datenbank')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
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
            'index' => \App\Filament\landlord\Resources\TenantResource\Pages\ListTenants::route('/'),
            'create' => \App\Filament\landlord\Resources\TenantResource\Pages\CreateTenant::route('/create'),
            'view' => \App\Filament\landlord\Resources\TenantResource\Pages\ViewTenant::route('/{record}'),
            'edit' => \App\Filament\landlord\Resources\TenantResource\Pages\EditTenant::route('/{record}/edit'),
        ];
    }
}
