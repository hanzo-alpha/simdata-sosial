<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusBpjsEnum;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusUsulanEnum;
use App\Filament\Resources\BantuanBpjsResource\Pages;
use App\Filament\Resources\BantuanBpjsResource\RelationManagers;
use App\Models\BantuanBpjs;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Wallo\FilamentSelectify\Components\ToggleButton;

class BantuanBpjsResource extends Resource
{
    protected static ?string $model = BantuanBpjs::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $slug = 'bantuan-bpjs';
    protected static ?string $label = 'Bantuan BPJS';
    protected static ?string $pluralLabel = 'Bantuan BPJS';
    protected static ?string $navigationLabel = 'Bantuan BPJS';
    protected static ?string $navigationGroup = 'Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Section::make('Data Keluarga')
                        ->schema([
                            Forms\Components\TextInput::make('nokk_tmt')
                                ->label('No. Kartu Keluarga (KK)')
                                ->required()
                                ->maxLength(20),
                            Forms\Components\TextInput::make('nik_tmt')
                                ->label('N I K')
                                ->required()
                                ->maxLength(20),
                            Forms\Components\TextInput::make('nama_lengkap')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('tempat_lahir')
                                ->label('Tempat Lahir')
                                ->maxLength(100),
                            Forms\Components\DatePicker::make('tgl_lahir')
                                ->label('Tgl. Lahir')
                                ->displayFormat('d/M/Y'),
                            Forms\Components\Select::make('jenis_kelamin')
                                ->label('Jenis Kelamin')
                                ->options(JenisKelaminEnum::class)
                                ->default(JenisKelaminEnum::LAKI),
                        ])->columns(2),
                    Forms\Components\Section::make('Alamat')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('alamat')
                                        ->required()
                                        ->columnSpanFull(),
                                    Select::make('kecamatan')
                                        ->required()
                                        ->searchable()
                                        ->reactive()
                                        ->options(function () {
                                            $kab = Kecamatan::query()->where('kabupaten_code',
                                                config('custom.default.kodekab'));
                                            if (!$kab) {
                                                return Kecamatan::where('kabupaten_code',
                                                    config('custom.default.kodekab'))
                                                    ->pluck('name', 'code');
                                            }

                                            return $kab->pluck('name', 'code');
                                        })
                                        ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                                    Select::make('kelurahan')
                                        ->required()
                                        ->options(function (callable $get) {
                                            return Kelurahan::query()->where('kecamatan_code',
                                                $get('kecamatan'))?->pluck('name',
                                                'code');
                                        })
                                        ->reactive()
                                        ->searchable(),
                                ]),

                            Grid::make(4)
                                ->schema([
                                    TextInput::make('dusun')
                                        ->label('Dusun')
                                        ->nullable(),
                                    TextInput::make('nort')
                                        ->label('RT')
                                        ->nullable(),
                                    TextInput::make('norw')
                                        ->label('RW')
                                        ->nullable(),
                                    TextInput::make('kodepos')
                                        ->label('Kodepos')
                                        ->default('90861')
                                        ->required(),
                                ]),
                        ]),
                ])->columnSpan(2),
                Forms\Components\Group::make([
                    Forms\Components\Section::make('Status')
                        ->schema([
                            Select::make('status_nikah')
                                ->options(StatusKawinBpjsEnum::class)
                                ->default(StatusKawinBpjsEnum::BELUM_KAWIN)
                                ->preload(),
                            Forms\Components\Select::make('status_bpjs')
                                ->label('Status BPJS')
                                ->enum(StatusBpjsEnum::class)
                                ->options(StatusBpjsEnum::class)
                                ->default(StatusBpjsEnum::PENGAKTIFAN)
                                ->live()
                                ->preload(),

                            Forms\Components\Select::make('status_usulan')
                                ->label('Status TL')
                                ->enum(StatusUsulanEnum::class)
                                ->options(StatusUsulanEnum::class)
                                ->default(StatusUsulanEnum::ONPROGRESS)
                                ->lazy()
                                ->visible(auth()->user()?->hasRole(['admin', 'super_admin']))
                                ->preload(),

                            ToggleButton::make('status_aktif')
                                ->label('Status Aktif')
                                ->offColor(StatusAktif::NONAKTIF->getColor())
                                ->onColor(StatusAktif::AKTIF->getColor())
                                ->offLabel(StatusAktif::NONAKTIF->getLabel())
                                ->onLabel(StatusAktif::AKTIF->getLabel())
                                ->visible(auth()->user()?->hasRole(['admin', 'super_admin']))
                                ->default(0),

                            Forms\Components\Textarea::make('keterangan')
                                ->visible(auth()->user()?->hasRole(['admin', 'super_admin']))
                                ->autosize()
                        ]),
                ])->columns(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->sortable()
                    ->description(fn($record) => 'Nik : ' . $record->nik_tmt)
                    ->searchable(),
                Tables\Columns\TextColumn::make('nokk_tmt')
                    ->label('No. KK')
                    ->sortable()
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->description(fn($record) => $record->tgl_lahir->format('d/M/Y'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->label('Tgl. Lahir')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge(),
                Tables\Columns\TextColumn::make('status_nikah')
                    ->label('Status Nikah')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge(),
                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->description(function ($record) {
                        $rt = $record['nort'];
                        $rw = $record['norw'];
                        $dusun = $record['dusun'];
                        $kodepos = $record['kodepos'];
                        $kec = $record->kec?->name;
                        $kel = $record->kel?->name;
                        return $dusun . ' ' . 'RT.' . $rt . '/' . 'RW.' . $rw . ' ' . $kec . ', ' . $kel . ', ' . $kodepos;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('kec.kecamatan')
                    ->label('Kecamatan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('kel.kelurahan')
                    ->label('Kelurahan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('bulan')
                    ->label('Periode')
                    ->formatStateUsing(fn($record) => bulan_to_string($record->bulan) . ' ' . $record->tahun),
                Tables\Columns\TextColumn::make('dusun')
                    ->label('Dusun')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_aktif')
                    ->label('Status Aktif')
                    ->sortable()
                    ->toggleable()
                    ->badge(),
                Tables\Columns\TextColumn::make('status_bpjs')
                    ->label('Status BPJS')
                    ->sortable()
                    ->toggleable()
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('status_aktif')
                    ->label('Status Aktif')
                    ->options(StatusAktif::class)
                    ->preload(),
                SelectFilter::make('status_bpjs')
                    ->label('Status BPJS')
                    ->options(StatusBpjsEnum::class),
                SelectFilter::make('status_nikah')
                    ->label('Status Nikah')
                    ->options(StatusKawinBpjsEnum::class),
                SelectFilter::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options(JenisKelaminEnum::class),
                DateRangeFilter::make('created_at')
                    ->label('Rentang Tanggal')
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->persistFiltersInSession()
            ->deselectAllRecordsWhenFiltered()
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
                ]),
            ]);
    }

//    public static function infolist(Infolist $infolist): Infolist
//    {
//        return $infolist
//            ->schema([
//                \Filament\Infolists\Components\Group::make([
//                    \Filament\Infolists\Components\Section::make('Informasi Keluarga')
//                        ->schema([
//                            TextEntry::make('dtks_id')
//                                ->label('DTKS ID')
//                                ->weight(FontWeight::SemiBold)
//                                ->copyable()
//                                ->icon('heroicon-o-identification')
//                                ->color('primary'),
//                            TextEntry::make('nokk')
//                                ->label('No. Kartu Keluarga (KK)')
//                                ->weight(FontWeight::SemiBold)
//                                ->copyable()
//                                ->icon('heroicon-o-identification')
//                                ->color('primary'),
//                            TextEntry::make('nik')
//                                ->label('No. Induk Kependudukan (NIK)')
//                                ->weight(FontWeight::SemiBold)
//                                ->icon('heroicon-o-identification')
//                                ->copyable()
//                                ->color('primary'),
//                            TextEntry::make('nama_lengkap')
//                                ->label('Nama Lengkap')
//                                ->weight(FontWeight::SemiBold)
//                                ->icon('heroicon-o-user')
//                                ->color('primary'),
//                            TextEntry::make('notelp')
//                                ->label('No. Telp/WA')
//                                ->icon('heroicon-o-device-phone-mobile')
//                                ->weight(FontWeight::SemiBold)
//                                ->color('primary'),
//                            TextEntry::make('tempat_lahir')
//                                ->label('Tempat Lahir')
//                                ->weight(FontWeight::SemiBold)
//                                ->icon('heroicon-o-home')
//                                ->color('primary'),
//                            TextEntry::make('tgl_lahir')
//                                ->label('Tanggal Lahir')
//                                ->formatStateUsing(function ($record) {
//                                    $tglLahir = Carbon::parse($record->tgl_lahir);
//                                    $umur = hitung_umur($tglLahir);
//
//                                    $tgl = $tglLahir->format('d F Y');
//                                    return $tgl . ' (' . $umur . ' tahun)';
//                                })
//                                ->icon('heroicon-o-calendar')
//                                ->weight(FontWeight::SemiBold)
//                                ->color('primary'),
//                            TextEntry::make('alamat.alamat')
//                                ->label('Alamat')
//                                ->icon('heroicon-o-map-pin')
//                                ->weight(FontWeight::SemiBold)
//                                ->color('primary'),
//                        ])->columns(2),
//                    \Filament\Infolists\Components\Section::make('Informasi Alamat')
//                        ->schema([
//                            TextEntry::make('alamat.alamat_lengkap')
//                                ->label('Alamat Lengkap')
//                                ->columnSpanFull()
//                                ->icon('heroicon-o-map-pin')
//                                ->weight(FontWeight::SemiBold)
//                                ->color('primary'),
//                            TextEntry::make('alamat.kec.name')
//                                ->label('Kecamatan'),
//                            TextEntry::make('alamat.kel.name')
//                                ->label('Kelurahan'),
//                            TextEntry::make('alamat.latitude')
//                                ->label('Latitude')
//                                ->state('-'),
//                            TextEntry::make('alamat.longitude')
//                                ->label('Longitude')
//                                ->state('-'),
//                        ])->columns(2),
//                ])->columnSpan(2),
//
//                \Filament\Infolists\Components\Group::make([
////                    \Filament\Infolists\Components\Section::make('Foto Rumah')
////                        ->schema([
////                            ImageEntry::make('bukti_foto')
////                                ->hiddenLabel()
////                                ->visibility('private')
////                                ->extraImgAttributes([
////                                    'alt' => 'foto rumah',
////                                    'loading' => 'lazy'
////                                ])
////                        ])->columns(3),
//
//                    \Filament\Infolists\Components\Section::make('Informasi Bantuan Dan Status Penerima')
//                        ->schema([
//                            TextEntry::make('jenis_bantuan.alias')
//                                ->label('Jenis Bantuan')
//                                ->weight(FontWeight::SemiBold)
//                                ->color('primary'),
//                            TextEntry::make('jenis_pekerjaan.nama_pekerjaan')
//                                ->label('Jenis Pekerjaan')
//                                ->weight(FontWeight::SemiBold)
//                                ->color('primary'),
//                            TextEntry::make('pendidikan_terakhir.nama_pendidikan')
//                                ->label('Pendidikan Terakhir')
////                                ->icon('heroicon-o-academic-cap')
//                                ->weight(FontWeight::SemiBold)
//                                ->color('primary'),
//                            TextEntry::make('hubungan_keluarga.nama_hubungan')
//                                ->label('Hubungan Keluarga')
//                                ->weight(FontWeight::SemiBold)
//                                ->color('primary'),
//                            TextEntry::make('nama_ibu_kandung')
//                                ->label('Nama Ibu Kandung')
//                                ->weight(FontWeight::SemiBold)
//                                ->color('primary'),
//                            TextEntry::make('jenis_kelamin')
//                                ->label('Jenis Kelamin')
//                                ->weight(FontWeight::SemiBold)
//                                ->badge(),
//                            TextEntry::make('status_kawin')
//                                ->label('Status Kawin')
//                                ->badge(),
//                            TextEntry::make('status_verifikasi')
//                                ->label('Verifikasi Berkas/Foto')
//                                ->badge(),
//                            TextEntry::make('status_bpjs')
//                                ->label('Status BPJS')
//                                ->badge(),
//                            TextEntry::make('status_aktif')
//                                ->label('Status Aktif')
//                                ->badge(),
//                        ])
//                        ->columns(2),
//                ])->columns(1),
//
//            ])->columns(3);
//    }

//    public static function getNavigationBadge(): ?string
//    {
//        return static::$model::where('status_aktif', StatusAktif::AKTIF)->count();
//    }

//    public static function getRecordSubNavigation(\Filament\Resources\Pages\Page $page): array
//    {
//        return $page->generateNavigationItems([
//            Pages\ListBantuanBpjs::class,
//            Pages\CreateBantuanBpjs::class,
//        ]);
//    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['nama_lengkap', 'dtks_id', 'nik', 'nokk']);
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
            'index' => Pages\ListBantuanBpjs::route('/'),
            'create' => Pages\CreateBantuanBpjs::route('/create'),
            'view' => Pages\ViewBantuanBpjs::route('/{record}'),
            'edit' => Pages\EditBantuanBpjs::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
