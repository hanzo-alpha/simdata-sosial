<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\HubunganKeluargaResource\Pages;
use App\Models\HubunganKeluarga;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

final class HubunganKeluargaResource extends Resource
{
    protected static ?string $model = HubunganKeluarga::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-lifebuoy';

    protected static ?string $slug = 'hubungan-keluarga';

    protected static ?string $label = 'Hubungan Keluarga';

    protected static ?string $pluralLabel = 'Hubungan Keluarga';

    protected static string|UnitEnum|null $navigationGroup = 'Dashboard Bantuan';

    protected static ?string $recordTitleAttribute = 'nama_hubungan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('nama_hubungan')
                    ->label('Nama Hubungan')
                    ->required()
                    ->autofocus(),
            ])->columns(1)
            ->inlineLabel();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada hubungan keluarga')
            ->emptyStateActions([
                Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('nama_hubungan'),
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
            'index' => Pages\ManageHubunganKeluargas::route('/'),
        ];
    }
}
