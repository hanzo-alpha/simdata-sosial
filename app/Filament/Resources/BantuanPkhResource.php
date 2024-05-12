<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Exports\ExportBantuanPkh;
use App\Filament\Resources\BantuanPkhResource\Pages;
use App\Filament\Resources\BantuanPkhResource\Widgets\BantuanPkhOverview;
use App\Models\BantuanPkh;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Str;

final class BantuanPkhResource extends Resource
{
    protected static ?string $model = BantuanPkh::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $slug = 'program-pkh';
    protected static ?string $label = 'Program PKH';
    protected static ?string $pluralLabel = 'Program PKH';
    protected static ?string $navigationLabel = 'Program PKH';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 3;
    protected static ?string $recordTitleAttribute = 'nama_penerima';

    public static function getWidgets(): array
    {
        return [
            BantuanPkhOverview::class,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Pribadi')->schema([
                    TextInput::make('dtks_id')
                        ->nullable()
                        ->default(Str::upper(Str::orderedUuid()->toString()))
                        ->maxLength(36),
                    TextInput::make('nokk')
                        ->required(),
                    TextInput::make('nik_ktp')
                        ->required(),
                    TextInput::make('nama_penerima')
                        ->required(),
                ])
                    ->columns(2),
                Section::make('Data Bantuan')->schema([
                    TextInput::make('tahap')
                        ->default(1),
                    TextInput::make('bansos')
                        ->default('PKH'),
                    TextInput::make('bank')
                        ->default('MANDIRI'),
                    TextInput::make('nominal')
                        ->default(0)
                        ->numeric(),
                    TextInput::make('dir')
                        ->default('DIR REHSOS'),
                    TextInput::make('gelombang')
                        ->default('GEL 1'),
                ])
//                    ->visibleOn(['edit', 'view'])
                    ->columns(2),
                Section::make('Data Alamat')->schema([
                    TextInput::make('alamat')
                        ->required()
                        ->columnSpanFull(),
                    Grid::make()->schema([
                        Select::make('provinsi')
                            ->nullable()
                            ->searchable()
                            ->reactive()
                            ->options(Provinsi::pluck('name', 'code'))
                            ->default(config('custom.default.kodeprov'))
                            ->afterStateUpdated(fn(callable $set) => $set('kabupaten', null)),

                        Select::make('kabupaten')
                            ->nullable()
                            ->options(function (callable $get) {
                                $kab = Kabupaten::query()->where('provinsi_code', $get('provinsi'));
                                if ( ! $kab) {
                                    return Kabupaten::where('code', config('custom.default.kodekab'))
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->reactive()
                            ->default(config('custom.default.kodekab'))
                            ->searchable()
//                            ->hidden(fn (callable $get) => ! $get('kecamatan'))
                            ->afterStateUpdated(fn(callable $set) => $set('kecamatan', null)),
                    ])
//                        ->visibleOn(['edit', 'view'])
                        ->columns(2),
                    Grid::make()->schema([
                        Select::make('kecamatan')
                            ->nullable()
                            ->searchable()
                            ->reactive()
                            ->options(function (callable $get) {
                                $kab = Kecamatan::query()->where('kabupaten_code', $get('kabupaten'));
                                if ( ! $kab) {
                                    return Kecamatan::where('kabupaten_code', config('custom.default.kodekab'))
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                        Select::make('kelurahan')
                            ->nullable()
                            ->options(function (callable $get) {
                                $kel = Kelurahan::query()->where('kecamatan_code', $get('kecamatan'));
                                if ( ! $kel) {
                                    return Kelurahan::where('kecamatan_code', '731211')
                                        ->pluck('name', 'code');
                                }

                                return $kel->pluck('name', 'code');
                            })
                            ->reactive()
                            ->searchable()
//                            ->hidden(fn (callable $get) => ! $get('kecamatan'))
                            ->afterStateUpdated(function (callable $set, $state): void {
                                $village = Kelurahan::where('code', $state)->first();
                                if ($village) {
                                    $set('latitude', $village['latitude']);
                                    $set('longitude', $village['longitude']);
                                    $set('location', [
                                        'lat' => (float) $village['latitude'],
                                        'lng' => (float) $village['longitude'],
                                    ]);
                                }

                            }),
                    ])
//                        ->visibleOn(['edit', 'view'])
                        ->columns(2),
                    Grid::make()->schema([
                        TextInput::make('dusun'),
                        TextInput::make('no_rt'),
                        TextInput::make('no_rw'),
                    ])
//                        ->visibleOn(['edit', 'view'])
                        ->columns(3),
                ])
//                    ->visibleOn(['edit', 'view'])
                    ->columns(2),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Group::make([
                \Filament\Infolists\Components\Section::make('INFORMASI PENERIMA MANFAAT')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextEntry::make('status_dtks')
                            ->label('STATUS DTKS')
                            ->weight(FontWeight::SemiBold)
                            ->badge(),
                        TextEntry::make('nokk')
                            ->label('NO. KARTU KELUARGA (KK)')
                            ->icon('heroicon-o-user-group')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary')
                            ->copyable(),
                        TextEntry::make('nik_ktp')
                            ->label('NO. NIK KTP')
                            ->icon('heroicon-o-identification')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary')
                            ->copyable(),
                        TextEntry::make('nama_penerima')
                            ->label('NAMA PENERIMA')
                            ->icon('heroicon-o-user-circle')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                    ])->columns(2),
                \Filament\Infolists\Components\Section::make('INFORMASI ALAMAT')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        TextEntry::make('alamat')
                            ->label('ALAMAT LENGKAP')
                            ->icon('heroicon-o-map-pin')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary')
                            ->formatStateUsing(function ($record) {
                                $alamat = Str::title($record->alamat);
                                $prov = Str::title($record->prov->name);
                                $kab = Str::title($record->kab->name);
                                $kec = Str::title($record->kec->name);
                                $kel = Str::title($record->kel->name);
                                $dusun = ("-" !== $record->dusun || null === $record->dusun)
                                    ? ', ' . Str::title($record->dusun)
                                    : "";
                                $rtrw = 'RT. ' . $record->no_rt . ' /RW. ' . $record->no_rw;
                                return $alamat
                                    . $dusun
                                    . ', '
                                    . $rtrw
                                    . ', Kec. '
                                    . $kec
                                    . ', Kel. '
                                    . $kel
                                    . ', '
                                    . $kab
                                    . ', '
                                    . $prov;
                            })
                            ->columnSpanFull(),
                        TextEntry::make('prov.name')
                            ->label('PROVINSI')
                            ->icon('heroicon-o-map-pin')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                        TextEntry::make('kab.name')
                            ->label('KABUPATEN')
                            ->icon('heroicon-o-map-pin')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                        TextEntry::make('kec.name')
                            ->label('KECAMATAN')
                            ->icon('heroicon-o-map-pin')
                            ->weight(FontWeight::SemiBold)
                            ->formatStateUsing(fn($state) => Str::upper($state))
                            ->color('primary'),
                        TextEntry::make('kel.name')
                            ->label('KELURAHAN')
                            ->formatStateUsing(fn($state) => Str::upper($state))
                            ->icon('heroicon-o-map-pin')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                        TextEntry::make('dusun')
                            ->label('DUSUN')
                            ->icon('heroicon-o-map-pin')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                        TextEntry::make('no_rt')
                            ->label('RT/RW')
                            ->formatStateUsing(fn($record) => 'RT. ' . $record->no_rt . '/RW. ' . $record->no_rw)
                            ->icon('heroicon-o-map-pin')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                    ])->columns(2),
            ])->columnSpan(2),

            Group::make([
                \Filament\Infolists\Components\Section::make('INFORMASI BANTUAN')
                    ->icon('heroicon-o-lifebuoy')
                    ->schema([
                        TextEntry::make('tahap')
                            ->label('TAHAP')
                            ->icon('heroicon-o-clipboard-document')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                        TextEntry::make('bansos')
                            ->label('BANSOS')
                            ->icon('heroicon-o-lifebuoy')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                        TextEntry::make('nominal')
                            ->label('NOMINAL')
                            ->icon('heroicon-o-currency-dollar')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                        TextEntry::make('bank')
                            ->label('BANK')
                            ->icon('heroicon-o-banknotes')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                        TextEntry::make('dir')
                            ->label('DIR')
                            ->icon('heroicon-o-viewfinder-circle')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                        TextEntry::make('gelombang')
                            ->label('GELOMBANG')
                            ->icon('heroicon-o-arrow-trending-up')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                        TextEntry::make('tahun')
                            ->label('TAHUN')
                            ->icon('heroicon-o-clock')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                        TextEntry::make('status_pkh')
                            ->label('STATUS PKH')
                            ->badge()
                            ->weight(FontWeight::SemiBold),
                    ])->columns(2),
            ])->columns(1),

        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll()
            ->deferLoading()
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('nama_penerima')
                    ->label('Nama Penerima')
                    ->sortable()
                    ->description(fn($record) => $record->status_dtks->getLabel())
                    ->searchable(),
                Tables\Columns\TextColumn::make('nokk')
                    ->label('No. KK')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_ktp')
                    ->label('N I K')
                    ->copyable()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_wilayah')
                    ->label('Kode Wilayah')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahap')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bansos')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_bantuan.nama_bantuan')
                    ->label('Bantuan')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nominal')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->sortable()
                    ->toggleable()
                    ->description(fn($record) => 'Kec. ' . $record->kec()->get()->first()->name . ' | Kel. ' .
                        $record->kel()->get()->first()->name)
                    ->searchable(),
                Tables\Columns\TextColumn::make('kec.name')
                    ->label('Kecamatan')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kel.name')
                    ->label('Kelurahan')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_rt')
                    ->label('No. RT')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_rw')
                    ->label('No. RW')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('dusun')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('dir')
                    ->label('Dir/Gel')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->description(fn($record): string => $record->gelombang)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_pkh')
                    ->label('Status')
                    ->alignCenter()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->badge()
                    ->sortable()
                    ->searchable(),
            ])
            ->searchPlaceholder('Cari...')
            ->filters([
                Tables\Filters\Filter::make('keckel')
                    ->indicator('Wilayah')
                    ->form([
                        Select::make('kecamatan')
                            ->options(function () {
                                return Kecamatan::query()
                                    ->where('kabupaten_code', setting('app.kodekab'))
                                    ->pluck('name', 'code');
                            })
                            ->live()
                            ->searchable()
                            ->native(false),
                        Select::make('kelurahan')
                            ->options(function (Get $get) {
                                return Kelurahan::query()
                                    ->whereIn('kecamatan_code', config('custom.kode_kecamatan'))
                                    ->where('kecamatan_code', $get('kecamatan'))
                                    ->pluck('name', 'code');
                            })
                            ->searchable()
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['kecamatan'],
                                fn(Builder $query, $data): Builder => $query->where('kecamatan', $data),
                            )
                            ->when(
                                $data['kelurahan'],
                                fn(Builder $query, $data): Builder => $query->where('kelurahan', $data),
                            );
                    }),
                SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(list_tahun())
                    ->attribute('tahun')
                    ->searchable(),
                DateRangeFilter::make('created_at')
                    ->label('Rentang Tanggal'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->deferFilters()
            ->deselectAllRecordsWhenFiltered()
            ->hiddenFilterIndicators()
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->label('Ekspor XLS yang dipilih')
                        ->color('primary')
                        ->icon('heroicon-o-arrow-up-tray')
                        ->exports([
                            ExportBantuanPkh::make()
                                ->except(['created_at', 'updated_at', 'deleted_at']),
                        ]),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBantuanPkh::route('/'),
            'create' => Pages\CreateBantuanPkh::route('/create'),
            'view' => Pages\ViewBantuanPkh::route('/{record}'),
            'edit' => Pages\EditBantuanPkh::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole(['super_admin'])) {
            return parent::getEloquentQuery()
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
        }

        return parent::getEloquentQuery()
            ->where('kelurahan', auth()->user()->instansi_id)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
