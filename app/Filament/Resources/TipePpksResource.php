<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TipePpksResource\Pages;
use App\Models\TipePpks;
use Awcodes\BadgeableColumn\Components\Badge;
use Awcodes\BadgeableColumn\Components\BadgeableColumn;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class TipePpksResource extends Resource
{
    protected static ?string $model = TipePpks::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $slug = 'tipe-ppks';
    protected static ?string $label = 'Tipe PPKS';
    protected static ?string $pluralLabel = 'Tipe PPKS';
    protected static ?string $navigationLabel = 'Tipe PPKS';
    protected static string|UnitEnum|null $navigationGroup = 'Dashboard Bantuan';
    protected static ?string $recordTitleAttribute = 'nama_tipe';

    public static function getGloballySearchableAttributes(): array
    {
        return ['nama_tipe', 'alias', 'kriteria_ppks.nama_kriteria'];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('nama_tipe')
                    ->label('Nama Tipe')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alias')
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('kriteria_ppks')
                    ->label('Kriteria PPKS')
                    ->relationship()
                    ->table([
                        Forms\Components\Repeater\TableColumn::make('Nama Kriteria'),
                    ])
                    ->simple(
                        Forms\Components\TextInput::make('nama_kriteria')
                            ->label('Nama Kriteria')
                            ->unique(ignoreRecord: true)
                            ->required(),
                    )
                    ->addActionLabel('Tambah Kriteria PPKS')
                    ->reorderableWithButtons()
                    ->collapsible()
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada tipe PPKS')
            ->emptyStateActions([
                Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->disabled(fn() => cek_batas_input('ppks'))
                    ->button(),
            ])
            ->columns([
                BadgeableColumn::make('nama_tipe')
                    ->label('Kategori PPKS')
                    ->suffixBadges([
                        Badge::make('alias')
                            ->label(fn($record) => $record->alias)
                            ->color('success'),
                    ])
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kriteria_ppks.nama_kriteria')
                    ->label('Kriteria PPKS')
                    ->badge()
                    ->color('primary')
                    ->inline()
                    ->searchable(),
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
            'index' => Pages\ManageTipePpks::route('/'),
        ];
    }
}
