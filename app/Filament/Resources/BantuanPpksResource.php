<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\JenisAnggaranEnum;
use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusDtksEnum;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusKondisiRumahEnum;
use App\Enums\StatusRumahEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Exports\ExportBantuanPpks;
use App\Filament\Resources\BantuanPpksResource\Pages;
use App\Models\BantuanPpks;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KriteriaPpks;
use App\Models\Provinsi;
use App\Models\TipePpks;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Wallo\FilamentSelectify\Components\ToggleButton;

final class BantuanPpksResource extends Resource
{
    protected static ?string $model = BantuanPpks::class;

    protected static ?string $navigationIcon = 'heroicon-o-window';
    protected static ?string $slug = 'program-ppks';
    protected static ?string $label = 'Program PPKS';
    protected static ?string $pluralLabel = 'Program PPKS';
    protected static ?string $navigationLabel = 'Program PPKS';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Section::make('Data Keluarga')
                        ->schema([
                            Select::make('status_dtks')
                                ->label('DTKS')
                                ->enum(StatusDtksEnum::class)
                                ->options(StatusDtksEnum::class)
                                ->preload()
                                ->default(StatusDtksEnum::DTKS)
                                ->lazy(),
                            TextInput::make('nokk')
                                ->label('No. Kartu Keluarga (KK)')
                                ->required()
                                ->default('TIDAK ADA')
                                ->maxLength(20),
                            TextInput::make('nik')
                                ->label('N I K')
                                ->required()
                                ->maxLength(20),
                            TextInput::make('nama_lengkap')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('nama_ibu_kandung')
                                ->label('Nama Ibu Kandung')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('tempat_lahir')
                                ->label('Tempat Lahir')
                                ->required()
                                ->maxLength(50),
                            DatePicker::make('tgl_lahir')
                                ->displayFormat('d/M/Y')
                                ->label('Tgl. Lahir')
                                ->required(),
                            Select::make('jenis_kelamin')
                                ->enum(JenisKelaminEnum::class)
                                ->options(JenisKelaminEnum::class)
                                ->required()
                                ->default(JenisKelaminEnum::LAKI),

                            Select::make('jenis_pekerjaan_id')
                                ->relationship('jenis_pekerjaan', 'nama_pekerjaan')
                                ->searchable()
                                ->required()
                                ->optionsLimit(15)
                                ->default(6)
                                ->preload(),
                            Select::make('pendidikan_terakhir_id')
                                ->relationship('pendidikan_terakhir', 'nama_pendidikan')
                                ->searchable()
                                ->required()
                                ->default(5)
                                ->optionsLimit(15)
                                ->preload(),
                            Select::make('hubungan_keluarga_id')
                                ->relationship('hubungan_keluarga', 'nama_hubungan')
                                ->searchable()
                                ->required()
                                ->default(7)
                                ->optionsLimit(15)
                                ->preload(),
                            Select::make('status_kawin')
                                ->enum(StatusKawinBpjsEnum::class)
                                ->options(StatusKawinBpjsEnum::class)
                                ->default(StatusKawinBpjsEnum::KAWIN)
                                ->preload(),
                            TextInput::make('penghasilan_rata_rata')
                                ->prefix('Rp. ')
                                ->default(0)
                                ->numeric(),

                            TextInput::make('jumlah_bantuan')
                                ->default(0)
                                ->numeric(),

                            TextInput::make('nama_bantuan')
                                ->default('-')
                                ->columnSpanFull(),

                        ])->columns(2),

                    Section::make('Data Alamat')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('alamat')
                                        ->required()
                                        ->columnSpanFull(),
                                    Select::make('provinsi')
                                        ->required()
                                        ->searchable()
                                        ->reactive()
                                        ->options(Provinsi::pluck('name', 'code'))
                                        ->default(setting('app.kodeprov', config('custom.default.kodeprov')))
                                        ->afterStateUpdated(function (callable $set): void {
                                            $set('kabupaten', null);
                                            $set('kecamatan', null);
                                            $set('kelurahan', null);
                                        }),
                                    Select::make('kabupaten')
                                        ->required()
                                        ->searchable()
                                        ->reactive()
                                        ->options(function (Get $get) {
                                            $kab = Kabupaten::query()->where('provinsi_code', $get('provinsi'));
                                            if ( ! $kab) {
                                                return Kabupaten::where(
                                                    'provinsi_code',
                                                    setting('app.kodekab', config('custom.default.kodekab')),
                                                )
                                                    ->pluck('name', 'code');
                                            }

                                            return $kab->pluck('name', 'code');
                                        })
                                        ->default(setting('app.kodekab', config('custom.default.kodekab')))
                                        ->afterStateUpdated(function (callable $set): void {
                                            $set('kecamatan', null);
                                            $set('kelurahan', null);
                                        }),
                                    Select::make('kecamatan')
                                        ->required()
                                        ->searchable()
                                        ->reactive()
                                        ->options(function (Get $get) {
                                            $kab = Kecamatan::query()->where('kabupaten_code', $get('kabupaten'));
                                            if ( ! $kab) {
                                                return Kecamatan::where(
                                                    'kabupaten_code',
                                                    setting('app.kodekab', config('custom.default.kodekab')),
                                                )
                                                    ->pluck('name', 'code');
                                            }

                                            return $kab->pluck('name', 'code');
                                        })
                                        ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                                    Select::make('kelurahan')
                                        ->required()
                                        ->options(function (callable $get) {
                                            return Kelurahan::query()->where(
                                                'kecamatan_code',
                                                $get('kecamatan'),
                                            )?->pluck(
                                                'name',
                                                'code',
                                            );
                                        })
                                        ->reactive()
                                        ->searchable(),
                                ]),

                            Grid::make(3)
                                ->schema([
                                    TextInput::make('dusun')
                                        ->label('Dusun')
                                        ->nullable(),
                                    TextInput::make('no_rt')
                                        ->label('RT')
                                        ->nullable(),
                                    TextInput::make('no_rw')
                                        ->label('RW')
                                        ->nullable(),
                                ]),
                        ]),
                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Section::make('Status PPKS/PMKS')
                        ->schema([
                            Select::make('jenis_bantuan_id')
                                ->required()
                                ->searchable()
                                ->hidden()
                                ->relationship(
                                    name: 'jenis_bantuan',
                                    titleAttribute: 'alias',
                                    modifyQueryUsing: fn(Builder $query) => $query->whereNotIn('id', [1, 2]),
                                )
                                ->default(4)
                                ->dehydrated(),

                            Select::make('bantuan_yang_pernah_diterima')
                                ->relationship('bansos_diterima', 'nama_bansos')
                                ->multiple()
                                ->searchable()
                                ->required()
                                ->default([1])
                                ->lazy()
                                ->preload(),

                            Select::make('tipe_ppks_id')
                                ->label('Kategori PPKS')
                                ->required()
                                ->searchable()
                                ->default(1)
                                ->options(TipePpks::pluck('nama_tipe', 'id'))
                                ->preload()
                                ->live()
                                ->afterStateUpdated(fn(Forms\Set $set) => $set('kriteria_ppks', null)),

                            Select::make('kriteria_ppks')
                                ->label('Kriteria PPKS')
                                ->required()
                                ->multiple()
                                ->searchable()
                                ->default(['36'])
                                ->options(function (callable $set, callable $get) {
                                    return KriteriaPpks::where(
                                        'tipe_ppks_id',
                                        $get('tipe_ppks_id'),
                                    )
                                        ?->pluck('nama_kriteria', 'id');
                                })
                                ->preload(),

                            Select::make('jenis_anggaran')
                                ->enum(JenisAnggaranEnum::class)
                                ->options(JenisAnggaranEnum::class)
                                ->default(JenisAnggaranEnum::APBD)
                                ->preload(),

                            TextInput::make('tahun_anggaran')
                                ->label('Tahun')
                                ->default(now()->year)
                                ->numeric(),

                            Forms\Components\Select::make('status_rumah_tinggal')
                                ->label('Status Rumah Tinggal')
                                ->enum(StatusRumahEnum::class)
                                ->options(StatusRumahEnum::class)
                                ->default(StatusRumahEnum::MILIK_SENDIRI)
                                ->lazy()
                                ->preload(),

                            Forms\Components\Select::make('status_kondisi_rumah')
                                ->label('Status Kondisi Rumah')
                                ->enum(StatusKondisiRumahEnum::class)
                                ->options(StatusKondisiRumahEnum::class)
                                ->default(StatusKondisiRumahEnum::BAIK)
                                ->lazy()
                                ->preload(),

                            Select::make('status_verifikasi')
                                ->label('Status Verifikasi')
                                ->enum(StatusVerifikasiEnum::class)
                                ->options(StatusVerifikasiEnum::class)
                                ->default(StatusVerifikasiEnum::UNVERIFIED)
                                ->preload()
                                ->visible(fn() => auth()->user()
                                    ?->hasRole(['super_admin', 'admin'])
                                    || auth()->user()->is_admin),

                            Forms\Components\Textarea::make('keterangan')
                                ->autosize(),

                            Forms\Components\FileUpload::make('bukti_foto')
                                ->label('Dokumentasi')
                                ->getUploadedFileNameForStorageUsing(
                                    fn(
                                        TemporaryUploadedFile $file,
                                    ): string => (string) str($file->getClientOriginalName())
                                        ->prepend(date('d-m-Y-H-i-s') . '-'),
                                )
                                ->preserveFilenames()
                                ->multiple()
                                ->reorderable()
                                ->appendFiles()
                                ->openable()
                                ->helperText('maks. 2MB')
                                ->maxFiles(3)
                                ->maxSize(2048)
                                ->columnSpanFull()
                                ->imagePreviewHeight('250')
                                ->previewable(false)
                                ->image(),

                            ToggleButton::make('status_aktif')
                                ->label('Status Aktif')
                                ->offColor('danger')
                                ->onColor('primary')
                                ->offLabel('Non Aktif')
                                ->onLabel('Aktif')
                                ->default(true),

                        ]),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll()
            ->deferLoading()
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('nik')
                    ->label('N I K')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nokk')
                    ->label('No. KK')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('notelp')
                    ->label('No.Telp/WA')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('penghasilan_rata_rata')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipe_ppks.nama_tipe')
                    ->label('Tipe PPKS')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kriteria_ppks')
                    ->label('Kriteria PPKS')
                    ->badge()
                    ->inline()
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => KriteriaPpks::find($state)->nama_kriteria),
                //                BadgeableColumn::make('tipe_ppks.nama_tipe')
                //                    ->label('Tipe Kriteria PPKS')
                //                    ->suffixBadges(function ($record) {
                //                        return $record->tipe_ppks
                //                            ->kriteria_ppks
                //                            ->whereIn('id', $record->kriteria_ppks)
                //                            ->map(fn($topic) => Badge::make($topic->nama_kriteria));
                //                    })
                //                    ->inline()
                //                    ->wrap()
                //                    ->searchable()
                //                    ->alignCenter(),
                Tables\Columns\TextColumn::make('bansos_diterima.nama_bansos')
                    ->inline()
                    ->badge()
                    ->color('warning')
                    ->alignCenter()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_rumah_tinggal')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable()
                    ->alignCenter()
                    ->badge(),
                Tables\Columns\TextColumn::make('status_kondisi_rumah')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable()
                    ->alignCenter()
                    ->badge(),
                Tables\Columns\IconColumn::make('status_aktif')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->alignCenter()
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('bantuan_yang_pernah_diterima')
                    ->label('Bantuan Diterima')
                    ->multiple()
                    ->relationship('bansos_diterima', 'nama_bansos')
//                    ->options(JenisBansosDiterimaEnum::class)
                    ->preload()
                    ->searchable(),
                SelectFilter::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->options(StatusVerifikasiEnum::class)
                    ->searchable(),
                SelectFilter::make('status_aktif')
                    ->label('Status Aktif')
                    ->options(StatusAktif::class)
                    ->searchable(),
                SelectFilter::make('tahun_anggaran')
                    ->label('Tahun')
                    ->options(list_tahun())
                    ->searchable(),
            ])
            ->deferFilters()
            ->persistFiltersInSession()
            ->deselectAllRecordsWhenFiltered()
            ->actions([
                Tables\Actions\Action::make('cetak ba')
                    ->label('Cetak Berita Acara')
                    ->icon('heroicon-o-printer')
                    ->url(fn($record) => route('ba.ppks', ['id' => $record,'m' => BantuanPpks::class]), true),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->label('Ekspor Ke Excel')
                        ->exports([
                            ExportBantuanPpks::make(),
                        ]),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Group::make([
                    \Filament\Infolists\Components\Section::make('Informasi Keluarga')
                        ->schema([
                            TextEntry::make('status_dtks')
                                ->label('DTKS Status')
                                ->weight(FontWeight::SemiBold)
                                ->copyable()
                                ->icon('heroicon-o-identification')
                                ->color('primary'),
                            TextEntry::make('nokk')
                                ->label('No. Kartu Keluarga (KK)')
                                ->weight(FontWeight::SemiBold)
                                ->copyable()
                                ->icon('heroicon-o-identification')
                                ->color('primary'),
                            TextEntry::make('nik')
                                ->label('No. Induk Kependudukan (NIK)')
                                ->weight(FontWeight::SemiBold)
                                ->icon('heroicon-o-identification')
                                ->copyable()
                                ->color('primary'),
                            TextEntry::make('nama_lengkap')
                                ->label('Nama Lengkap')
                                ->weight(FontWeight::SemiBold)
                                ->icon('heroicon-o-user')
                                ->color('primary'),
                            TextEntry::make('tempat_lahir')
                                ->label('Tempat Lahir')
                                ->weight(FontWeight::SemiBold)
                                ->icon('heroicon-o-home')
                                ->color('primary'),
                            TextEntry::make('tgl_lahir')
                                ->label('Tanggal Lahir')
                                ->date('d F Y')
                                ->icon('heroicon-o-calendar')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('status_kawin')
                                ->label('Status Kawin')
                                ->icon('heroicon-o-heart')
                                ->weight(FontWeight::SemiBold),
                            TextEntry::make('jenis_kelamin')
                                ->label('Jenis Kelamin')
                                ->icon('heroicon-o-heart')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('tipe_ppks.nama_tipe')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary')
                                ->label('Tipe PPKS'),
                            TextEntry::make('kriteria_ppks')
                                ->formatStateUsing(fn($state) => KriteriaPpks::find($state)->nama_kriteria)
                                ->listWithLineBreaks()
                                ->badge()
                                ->label('Kriteria PPKS'),
                            TextEntry::make('penghasilan_rata_rata')
                                ->label('Penghasilan Rata-Rata')
                                ->icon('heroicon-o-banknotes')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('keterangan')
                                ->label('Keterangan')
                                ->icon('heroicon-o-bookmark')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                        ])->columns(2),
                    \Filament\Infolists\Components\Section::make('Informasi Alamat')
                        ->schema([
                            TextEntry::make('alamat')
                                ->label('Alamat')
                                ->columnSpanFull()
                                ->icon('heroicon-o-map-pin')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            //                            TextEntry::make('prov.name')
                            //                                ->label('Provinsi'),
                            //                            TextEntry::make('kab.name')
                            //                                ->label('Kabupaten'),
                            TextEntry::make('kec.name')
                                ->label('Kecamatan'),
                            TextEntry::make('kel.name')
                                ->label('Kelurahan'),
                            TextEntry::make('latitude')
                                ->label('Latitude')
                                ->state('-'),
                            TextEntry::make('longitude')
                                ->label('Longitude')
                                ->state('-'),
                        ])->columns(2),
                ])->columnSpan(2),

                Group::make([
                    \Filament\Infolists\Components\Section::make('Foto Rumah')
                        ->schema([
                            ImageEntry::make('bukti_foto')
                                ->hiddenLabel()
                                ->extraImgAttributes([
                                    'alt' => 'foto rumah',
                                    'loading' => 'lazy',
                                ]),
                        ])->columns(3),

                    \Filament\Infolists\Components\Section::make('Informasi Bantuan Dan Status Penerima')
                        ->schema([
                            //                            TextEntry::make('jenis_bantuan.alias')
                            //                                ->label('Jenis Bantuan')
                            //                                ->weight(FontWeight::SemiBold)
                            //                                ->color('primary'),
                            TextEntry::make('nama_bantuan')
                                ->label('Nama Bantuan')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('jumlah_bantuan')
                                ->label('Jumlah Bantuan')
                                ->icon('heroicon-o-bookmark')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('bantuan_yang_pernah_diterima')
                                ->label('Bantuan Yang Pernah Diterima')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('jenis_pekerjaan.nama_pekerjaan')
                                ->label('Jenis Pekerjaan')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('pendidikan_terakhir.nama_pendidikan')
                                ->label('Pendidikan Terakhir')
                                ->icon('heroicon-o-academic-cap')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('hubungan_keluarga.nama_hubungan')
                                ->label('Hubungan Keluarga')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('nama_ibu_kandung')
                                ->label('Nama Ibu Kandung')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('jenis_kelamin')
                                ->label('Jenis Kelamin')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('status_kawin')
                                ->label('Status Kawin')
                                ->badge(),
                            TextEntry::make('jenis_anggaran')
                                ->label('Jenis Anggaran')
                                ->badge(),
                            TextEntry::make('tahun_anggaran')
                                ->label('Tahun'),
                            TextEntry::make('status_rumah_tinggal')
                                ->label('Rumah Tinggal')
                                ->badge(),
                            TextEntry::make('status_kondisi_rumah')
                                ->label('Kondisi Rumah')
                                ->badge(),
                            TextEntry::make('status_aktif')
                                ->label('Status Aktif')
                                ->badge(),
                        ])
                        ->columns(2),
                ])->columns(1),

            ])->columns(3);
    }

    //    public static function getNavigationBadge(): ?string
    //    {
    //        return static::$model::where('status_aktif', StatusAktif::AKTIF)->count();
    //    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['nama_lengkap', 'dtks_id', 'nik', 'nokk']);
    }

    public static function getRelations(): array
    {
        return [
            //            KriteriaRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBantuanPpks::route('/'),
            'create' => Pages\CreateBantuanPpks::route('/create'),
            'view' => Pages\ViewBantuanPpks::route('/{record}'),
            'edit' => Pages\EditBantuanPpks::route('/{record}/edit'),
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
