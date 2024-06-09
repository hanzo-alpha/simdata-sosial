<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PendidikanTerakhirResource\Pages;
use App\Models\PendidikanTerakhir;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class PendidikanTerakhirResource extends Resource
{
    protected static ?string $model = PendidikanTerakhir::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $slug = 'pendidikan-terakhir';
    protected static ?string $label = 'Pendidikan Terakhir';
    protected static ?string $pluralLabel = 'Pendidikan Terakhir';
    protected static ?string $navigationGroup = 'Dashboard Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pendidikan')
                    ->label('Nama Pendidikan')
                    ->required()
                    ->autofocus(),
            ])->columns(1)
            ->inlineLabel();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada pendidikan terakhir')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('nama_pendidikan'),
            ])
            ->filters([

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
