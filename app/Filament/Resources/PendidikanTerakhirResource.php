<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PendidikanTerakhirResource\Pages;
use App\Models\PendidikanTerakhir;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

final class PendidikanTerakhirResource extends Resource
{
    protected static ?string $model = PendidikanTerakhir::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $slug = 'pendidikan-terakhir';
    protected static ?string $label = 'Pendidikan Terakhir';
    protected static ?string $pluralLabel = 'Pendidikan Terakhir';
    protected static string|UnitEnum|null $navigationGroup = 'Dashboard Bantuan';
    protected static ?string $recordTitleAttribute = 'nama_pendidikan';

    public static function form(Schema $schema): Schema
    {
        return $schema
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
                Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('nama_pendidikan'),
            ])
            ->filters([

            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
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
