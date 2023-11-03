<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendidikanTerakhirResource\Pages;
use App\Filament\Resources\PendidikanTerakhirResource\RelationManagers;
use App\Models\PendidikanTerakhir;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PendidikanTerakhirResource extends Resource
{
    protected static ?string $model = PendidikanTerakhir::class;

    protected static ?string $slug = 'pendidikan-terakhir';
    protected static ?string $label = 'Pendidikan Terakhir';
    protected static ?string $pluralLabel = 'Pendidikan Terakhir';
    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pendidikan')
                    ->required()
                    ->autofocus()
            ])->columns(1)
            ->inlineLabel();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_pendidikan')
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
            'index' => Pages\ManagePendidikanTerakhirs::route('/'),
        ];
    }
}
