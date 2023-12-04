<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BantuanResource\Pages;
use App\Filament\Resources\BantuanResource\RelationManagers;
use App\Models\Bantuan;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BantuanResource extends Resource
{
    protected static ?string $model = Bantuan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
//                Tables\Columns\TextColumn::make('bantuan.nama_bantuan'),
                Tables\Columns\TextColumn::make('nama_bantuan'),
                Tables\Columns\TextColumn::make('alias'),
                Tables\Columns\TextColumn::make('deskripsi'),
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
            'index' => Pages\ListBantuans::route('/'),
            'create' => Pages\CreateBantuan::route('/create'),
            'view' => Pages\ViewBantuan::route('/{record}'),
            'edit' => Pages\EditBantuan::route('/{record}/edit'),
        ];
    }
}
