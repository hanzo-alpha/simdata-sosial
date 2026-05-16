<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\JabatanEnum;
use App\Enums\StatusPenandatangan;
use App\Filament\Resources\PenandatanganResource\Pages;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Penandatangan;
use BackedEnum;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PenandatanganResource extends Resource
{
    protected static ?string $model = Penandatangan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $slug = 'penandatangan';
    protected static ?string $label = 'Penandatangan';
    protected static ?string $pluralLabel = 'Penandatangan';
    protected static ?string $navigationLabel = 'Penandatangan';
    protected static string|UnitEnum|null $navigationGroup = 'Dashboard Bantuan';
    //    protected static bool $isScopedToTenant = false;
    protected static ?string $recordTitleAttribute = 'nama_penandatangan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('kode_kecamatan')
                    ->label('Kecamatan')
                    ->options(Kecamatan::where('kabupaten_code', setting('app.kodekab'))->pluck('name', 'code'))
                    ->searchable()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (callable $set): void {
                        $set('kode_instansi', null);
                    })
                    ->required(),
                Select::make('kode_instansi')
                    ->label('Kelurahan')
                    ->options(function (callable $get) {
                        $kelurahan = Kelurahan::where('kecamatan_code', $get('kode_kecamatan'))->pluck('name', 'code');
                        return $kelurahan ?? [];
                    })
                    ->searchable()
                    ->required(),
                TextInput::make('nama_penandatangan')
                    ->required(),
                TextInput::make('nip')
                    ->required(),
                Select::make('jabatan')
                    ->enum(JabatanEnum::class)
                    ->options(JabatanEnum::class)
                    ->searchable()
                    ->native(false)
                    ->preload()
                    ->required(),

                ToggleButtons::make('status_penandatangan')
                    ->label('Status')
                    ->inline()
                    ->options(StatusPenandatangan::class)
                    ->default(StatusPenandatangan::AKTIF)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->poll()
            ->defaultSort('jabatan')
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada penandatangan')
            ->emptyStateActions([
                Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('kode_kecamatan')
                    ->label('Kecamatan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(fn($state): string => Kecamatan::where('code', $state)->first()?->name ?? '-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_instansi')
                    ->label('Instansi')
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn($state): string => Kelurahan::where('code', $state)->first()?->name ?? '-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nip')
                    ->sortable()
                    ->toggleable()
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_penandatangan')
                    ->label('Nama Penandatangan')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan')
                    ->sortable()
                    ->toggleable()
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_penandatangan')
                    ->label('Status')
                    ->sortable()
                    ->searchable()
                    ->alignCenter()
                    ->badge(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kode_instansi')
                    ->label('Instansi')
                    ->options(Kelurahan::whereIn(
                        'kecamatan_code',
                        config('custom.kode_kecamatan'),
                    )->pluck('name', 'code'))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('status_penandatangan')
                    ->label('Status Penandatangan')
                    ->options(StatusPenandatangan::class)
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('jabatan')
                    ->options(JabatanEnum::class)
                    ->searchable()
                    ->preload(),
            ])
            ->deferLoading()
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()
                        ->after(fn(\Illuminate\Support\Collection $records) => activity()
                            ->log('Hapus masal ' . $records->count() . ' data penandatangan')),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePenandatangans::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }
}
