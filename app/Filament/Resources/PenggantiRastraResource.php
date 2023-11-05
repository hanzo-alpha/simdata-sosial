<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenggantiRastraResource\Pages;
use App\Filament\Resources\PenggantiRastraResource\RelationManagers;
use App\Models\PenggantiRastra;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PenggantiRastraResource extends Resource
{
    protected static ?string $model = PenggantiRastra::class;

    protected static ?string $slug = 'pengganti-rastra';
    protected static ?string $label = 'Pengganti RASTRA';
    protected static ?string $pluralLabel = 'Pengganti RASTRA';
    protected static ?string $navigationLabel = 'Pengganti RASTRA';
    protected static ?string $navigationGroup = 'Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePenggantiRastras::route('/'),
        ];
    }
}
