<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\JenisPekerjaanResource\Pages;
use App\Models\JenisPekerjaan;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

final class JenisPekerjaanResource extends Resource
{
    protected static ?string $model = JenisPekerjaan::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $slug = 'jenis-pekerjaan';
    protected static ?string $label = 'Jenis Pekerjaan';
    protected static ?string $pluralLabel = 'Jenis Pekerjaan';
    protected static string|UnitEnum|null $navigationGroup = 'Dashboard Bantuan';
    protected static ?string $recordTitleAttribute = 'nama_pekerjaan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('nama_pekerjaan')
                    ->label('Nama Pekerjaan')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada jenis pekerjaan')
            ->emptyStateActions([
                Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('nama_pekerjaan'),
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
            'index' => Pages\ManageJenisPekerjaan::route('/'),
        ];
    }
}
