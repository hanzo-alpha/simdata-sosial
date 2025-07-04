<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\JenisAnggaranEnum;
use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusDtksEnum;
use App\Enums\StatusKawinUmumEnum;
use App\Enums\StatusKondisiRumahEnum;
use App\Enums\StatusRumahEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Exports\ExportBantuanPpks;
use App\Filament\Resources\BantuanPpksResource\Pages;
use App\Filament\Resources\BantuanPpksResource\Widgets\BantuanPpksOverview;
use App\Models\BantuanPpks;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KriteriaPpks;
use App\Models\Provinsi;
use App\Models\TipePpks;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
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
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Wallo\FilamentSelectify\Components\ToggleButton;

class BantuanPpksResource extends Resource
{
    protected static ?string $model = BantuanPpks::class;

    protected static ?string $navigationIcon = 'heroicon-o-window';
    protected static ?string $slug = 'program-ppks';
    protected static ?string $label = 'Program PPKS';
    protected static ?string $pluralLabel = 'Program PPKS';
    protected static ?string $navigationLabel = 'Program PPKS';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 5;
    protected static ?string $recordTitleAttribute = 'nama_lengkap';

    public static function getGloballySearchableAttributes(): array
    {
        return ['nokk', 'nik', 'nama_lengkap', 'kel.name', 'kec.name', 'kab.name'];
    }

    public static function getWidgets(): array
    {
        return [
            BantuanPpksOverview::class,
        ];
    }

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
                                ->live(debounce: 500)
                                ->afterStateUpdated(function (Page $livewire, TextInput $component): void {
                                    $livewire->validateOnly($component->getStatePath());
                                })
                                ->minLength(16)
                                ->maxLength(16),
                            TextInput::make('nik')
                                ->label('No. Induk Kependudukan (NIK)')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->live(debounce: 500)
                                ->afterStateUpdated(function (Page $livewire, TextInput $component): void {
                                    $livewire->validateOnly($component->getStatePath());
                                })
                                ->minLength(16)
                                ->maxLength(16),
                            TextInput::make('nama_lengkap')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('nama_ibu_kandung')
                                ->label('Nama Ibu Kandung')
                                ->required()
                                ->live(debounce: 500)
                                ->afterStateUpdated(function (Page $livewire, TextInput $component): void {
                                    $livewire->validateOnly($component->getStatePath());
                                })
                                ->maxLength(255),
                            TextInput::make('tempat_lahir')
                                ->label('Tempat Lahir')
                                ->required()
                                ->live(debounce: 500)
                                ->afterStateUpdated(function (Page $livewire, TextInput $component): void {
                                    $livewire->validateOnly($component->getStatePath());
                                })
                                ->maxLength(50),
                            DatePicker::make('tgl_lahir')
                                ->displayFormat(setting('app.format_tgl'))
                                ->label('Tgl. Lahir')
                                ->required()
                                ->live(debounce: 500)
                                ->afterStateUpdated(function (Page $livewire, DatePicker $component): void {
                                    $livewire->validateOnly($component->getStatePath());
                                }),
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
                                ->default(7)
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
                                ->enum(StatusKawinUmumEnum::class)
                                ->options(StatusKawinUmumEnum::class)
                                ->default(StatusKawinUmumEnum::BELUM_KAWIN)
                                ->preload(),
                            TextInput::make('penghasilan_rata_rata')
                                ->prefix('Rp. ')
                                ->default(0)
                                ->numeric(),

                            //                            TextInput::make('jumlah_bantuan')
                            //                                ->default(0)
                            //                                ->numeric(),
                            //
                            //                                                        Forms\Components\Select::make('barang_id')
                            //                                                            ->label('Item Bantuan')
                            //                                                            ->relationship(
                            //                                                                name: 'barang',
                            //                                                                titleAttribute: 'nama_barang',
                            //                                                                modifyQueryUsing: fn(Builder $query) => $query->where('jenis_bantuan_id', 4),
                            //                                                            )
                            //                                                            ->native(false)
                            //                                                            ->preload()
                            //                                                            ->getOptionLabelFromRecordUsing(
                            //                                                                fn(
                            //                                                                    Model $record,
                            //                                                                ) => "<strong>{$record->nama_barang}</strong> - {$record->kel?->name}",
                            //                                                            )
                            //                                                            ->allowHtml()
                            //                                                            ->searchable()
                            //                                                            ->noSearchResultsMessage('Item tidak ditemukan')
                            //                                                            ->searchPrompt('Cari Item Bantuan')
                            //                                                            ->required(),
                            //
                            //                            TextInput::make('nama_bantuan')
                            //                                ->label('Nama Bantuan')
                            //                                ->default('-'),

                        ])->columns(2),

                    Section::make('Detail Bantuan PPKS')
                        ->schema([
                            TableRepeater::make('detailBantuanPpks')
                                ->relationship('detailBantuanPpks')
                                ->hiddenLabel()
                                ->columnSpanFull()
                                ->addActionLabel('Tambah Detail Bantuan')
                                ->headers([
                                    Header::make('Item Bantuan')->align('center'),
                                    Header::make('Nama Bantuan')->align('center'),
                                    Header::make('Jumlah')->align('center'),
                                    Header::make('Jenis Anggaran')->align('center'),
                                    Header::make('Tahun Anggaran')->align('center'),
                                    Header::make('Bansos Diterima')->align('center'),
                                ])
                                ->schema([
                                    Forms\Components\Select::make('barang_id')
                                        ->label('Item Bantuan')
                                        ->relationship(
                                            name: 'barang',
                                            titleAttribute: 'nama_barang',
                                            modifyQueryUsing: fn(Builder $query) => $query->where(
                                                'jenis_bantuan_id',
                                                4,
                                            ),
                                        )
                                        ->native(false)
                                        ->preload()
                                        ->getOptionLabelFromRecordUsing(
                                            fn(
                                                Model $record,
                                            ) => "<strong>{$record->nama_barang}</strong> - {$record->kel?->name}",
                                        )
                                        ->allowHtml()
                                        ->searchable()
                                        ->noSearchResultsMessage('Item tidak ditemukan')
                                        ->searchPrompt('Cari Item Bantuan')
                                        ->required(),
                                    TextInput::make('nama_bantuan')
                                        ->label('Nama Bantuan'),
                                    TextInput::make('jumlah_bantuan')
                                        ->label('Jumlah Bantuan')
                                        ->default(1),
                                    Forms\Components\Select::make('jenis_anggaran')
                                        ->label('Jenis Anggaran')
                                        ->options(JenisAnggaranEnum::class)
                                        ->default(JenisAnggaranEnum::APBD)
                                        ->preload()
//                                        ->extraAttributes(['class' => 'p-2'])
                                        ->native(false),
                                    Select::make('tahun_anggaran')
                                        ->label('Tahun Anggaran')
                                        ->options(list_tahun())
                                        ->preload()
                                        ->native(false)
                                        ->default(now()->year),
                                    Select::make('bansos_diterima')
                                        ->label('Bantuan Diterima')
                                        ->relationship('bansosDiterima', 'nama_bansos')
                                        ->multiple()
                                        ->searchable()
                                        ->native(false)
                                        ->required()
                                        ->default(['14', '13'])
                                        ->preload(),
                                ]),
                        ])->columns(2),

                    Section::make('Data Alamat')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('alamat')
                                        ->required()
                                        ->live(debounce: 500)
                                        ->afterStateUpdated(function (Page $livewire, TextInput $component): void {
                                            $livewire->validateOnly($component->getStatePath());
                                        })
                                        ->columnSpanFull(),
                                    Select::make('provinsi')
                                        ->required()
                                        ->searchable()
                                        ->live()
                                        ->native(false)
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
                                        ->live()
                                        ->native(false)
                                        ->options(function (Get $get) {
                                            $kab = Kabupaten::query()->where('provinsi_code', $get('provinsi'));
                                            if (!$kab) {
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
                                        ->live()
                                        ->native(false)
                                        ->options(function (Get $get) {
                                            $kab = Kecamatan::query()->where('kabupaten_code', $get('kabupaten'));
                                            if (!$kab) {
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
                                        ->native(false)
                                        ->options(fn(callable $get) => Kelurahan::query()
                                            ->when(
                                                auth()->user()->instansi_id,
                                                fn(Builder $query) => $query->where(
                                                    'code',
                                                    auth()->user()->instansi_id,
                                                ),
                                            )
                                            ->where(
                                                'kecamatan_code',
                                                $get('kecamatan'),
                                            )?->pluck(
                                                'name',
                                                'code',
                                            ))
                                        ->live()
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
                    Section::make('Berita Acara')
                        ->schema([
                            Forms\Components\DateTimePicker::make('tgl_ba')
                                ->label('Tgl. Berita Acara')
                                ->displayFormat('d/M/Y H:i:s')
                                ->nullable()
                                ->default(now()),
                            Select::make('penandatangan_id')
                                ->relationship(
                                    name: 'penandatangan',
                                    titleAttribute: 'nama_penandatangan',
                                    modifyQueryUsing: fn(Builder $query) => $query->with(['kecamatan', 'kelurahan']),
                                )
                                ->native(false)
                                ->noSearchResultsMessage('Penandatangan tidak ditemukan')
                                ->searchPrompt('Cari Penandatangan')
                                ->getOptionLabelFromRecordUsing(
                                    fn(
                                        Model $record,
                                    ) => "<strong>{$record->nama_penandatangan}</strong><br>{$record->jabatan->value} - {$record->kelurahan?->name}",
                                )
                                ->allowHtml()
                                ->live(onBlur: true)
                                ->preload()
                                ->searchable()
                                ->required(),
                        ]),
                    Section::make('Status PPKS')
                        ->schema([
                            //                            Select::make('bansos_diterima')
                            //                                ->label('Bantuan Yang Pernah Diterima')
                            //                                ->relationship('bansos_diterima', 'nama_bansos')
                            //                                ->multiple()
                            //                                ->searchable()
                            //                                ->native(false)
                            //                                ->required()
                            //                                ->default([14, 13])
                            //                                ->preload(),

                            Select::make('tipe_ppks_id')
                                ->label('Kategori PPKS')
                                ->required()
                                ->native(false)
                                ->searchable()
                                ->default(1)
                                ->options(TipePpks::pluck('nama_tipe', 'id'))
                                ->preload()
                                ->live()
                                ->afterStateUpdated(fn(Forms\Set $set) => $set('kriteriaPpks', null)),

                            Select::make('kriteriaPpks')
                                ->label('Kriteria PPKS')
                                ->relationship(
                                    name: 'kriteriaPpks',
                                    titleAttribute: 'nama_kriteria',
                                    ignoreRecord: true,
                                )
                                ->required()
                                ->native(false)
                                ->multiple()
                                ->searchable()
                                ->live(debounce: 500)
                                ->afterStateUpdated(function (Page $livewire, Select $component): void {
                                    $livewire->validateOnly($component->getStatePath());
                                })
                                ->options(fn(callable $set, callable $get) => KriteriaPpks::where(
                                    'tipe_ppks_id',
                                    $get('tipe_ppks_id'),
                                )
                                    ?->pluck('nama_kriteria', 'id'))
                                ->preload(),

                            //                            Select::make('jenis_anggaran')
                            //                                ->enum(JenisAnggaranEnum::class)
                            //                                ->options(JenisAnggaranEnum::class)
                            //                                ->default(JenisAnggaranEnum::APBD)
                            //                                ->native(false)
                            //                                ->preload(),
                            //
                            //                            TextInput::make('tahun_anggaran')
                            //                                ->label('Tahun')
                            //                                ->default(now()->year)
                            //                                ->numeric(),

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
                                ->native(false)
                                ->preload(),

                            Select::make('status_verifikasi')
                                ->label('Status Verifikasi')
                                ->enum(StatusVerifikasiEnum::class)
                                ->options(StatusVerifikasiEnum::class)
                                ->default(StatusVerifikasiEnum::UNVERIFIED)
                                ->native(false)
                                ->preload()
                                ->visible(fn() => auth()->user()
                                        ?->hasRole(['super_admin', 'admin'])
                                    || auth()->user()->is_admin),

                            Forms\Components\Textarea::make('keterangan')
                                ->nullable()
                                ->autosize(),

                            Forms\Components\FileUpload::make('bukti_foto')
                                ->label('Dokumentasi')
                                ->getUploadedFileNameForStorageUsing(
                                    fn(
                                        TemporaryUploadedFile $file,
                                    ): string => (string) str($file->getClientOriginalName())
                                        ->prepend(date('d-m-Y-H-i-s').'-'),
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
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada bantuan PPKS')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->disabled(fn(): bool => cek_batas_input(setting('app.batas_tgl_input_ppks')))
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->copyable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => Str::mask($state, '*', 2, 12)),
                Tables\Columns\TextColumn::make('nokk')
                    ->label('No. KK')
                    ->copyable()
                    ->formatStateUsing(fn($state) => Str::mask($state, '*', 2, 12))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->description(fn($record) => Str::mask($record->nik, '*', 2, 12))
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->description(fn($record) => $record->tgl_lahir->format('d/m/Y'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->label('Tgl. Lahir')
                    ->date('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_ibu_kandung')
                    ->label('Nama Ibu Kandung')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('pendidikan_terakhir.nama_pendidikan')
                    ->label('Pendidikan Terakhir')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('hubungan_keluarga.nama_hubungan')
                    ->label('Hubungan Keluarga')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_pekerjaan.nama_pekerjaan')
                    ->label('Jenis Pekerjaan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('prov.name')
                    ->label('Provinsi')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('kab.name')
                    ->label('Kabupaten')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('kec.name')
                    ->label('Kecamatan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('kel.name')
                    ->label('Kelurahan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('dusun')
                    ->label('Dusun')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_rt')
                    ->label('RT/RW')
                    ->formatStateUsing(fn($record) => $record->no_rt.'/'.$record->no_rw)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('penghasilan_rata_rata')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_kawin')
                    ->label('Status Kawin')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipe_ppks.nama_tipe')
                    ->label('Tipe PPKS')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kriteriaPpks.nama_kriteria')
                    ->label('Kriteria PPKS')
                    ->badge()
                    ->inline()
                    ->separator(', ')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('detailBantuanPpks.bansosDiterima.nama_bansos')
                    ->label('Bantuan Yg Pernah Diterima')
                    ->inline()
                    ->badge()
                    ->color('warning')
                    ->alignCenter()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_rumah_tinggal')
                    ->label('Status Rumah')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable()
                    ->alignCenter()
                    ->badge(),
                Tables\Columns\TextColumn::make('status_kondisi_rumah')
                    ->label('Status Kondisi Rumah')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable()
                    ->alignCenter()
                    ->badge(),
                Tables\Columns\TextColumn::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->alignCenter()
                    ->badge(),
                Tables\Columns\IconColumn::make('status_aktif')
                    ->label('Status Aktif')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->alignCenter()
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\Filter::make('tipe_kriteria')
                    ->indicator('Kriteria')
                    ->columnSpanFull()
                    ->form([
                        Forms\Components\Fieldset::make()->schema([
                            Forms\Components\Select::make('tipe_ppks_id')
                                ->label('Tipe PPKS')
                                ->options(fn() => TipePpks::query()
                                    ->pluck('nama_tipe', 'id'))
                                ->live()
                                ->searchable()
                                ->native(false)
                                ->afterStateUpdated(fn(Forms\Set $set) => $set('kriteriaPpks', null)),
                            Forms\Components\Select::make('kriteriaPpks')
                                ->label('Kriteria PPKS')
                                ->options(fn(Forms\Get $get) => KriteriaPpks::query()
                                    ->where('tipe_ppks_id', $get('tipe_ppks_id'))
                                    ->pluck('nama_kriteria', 'id'))
                                ->searchable()
                                ->native(false),
                        ])->columnSpanFull(),
                    ])
                    ->query(
                        fn(Builder $query, array $data): Builder => $query
                            ->when(
                                $data['tipe_ppks_id'],
                                fn(Builder $query, $data): Builder => $query->where('tipe_ppks_id', $data),
                            )
                            ->when(
                                $data['kriteriaPpks'],
                                fn(Builder $query, $data): Builder => $query->whereHas(
                                    'kriteriaPpks',
                                    function ($query) use ($data): void {
                                        $query->where('kriteria_ppks_id', $data);
                                    },
                                ),
                            ),
                    ),
                //                SelectFilter::make('bansos_diterima')
                //                    ->label('Bantuan Diterima')
                //                    ->multiple()
                //                    ->relationship('bansos_diterima', 'nama_bansos')
                //                    ->preload()
                //                    ->searchable(),
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
                Tables\Filters\TrashedFilter::make(),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
//            ->filtersFormColumns(4)
//            ->filtersFormSchema(fn(array $filters): array => [
//                Section::make('Visibility')
//                    ->description('These filters affect the visibility of the records in the table.')
//                    ->schema([
//                        $filters['tipe_kriteria'],
//                    ])
//                    ->columns(2)
//                    ->columnSpanFull(),
//                $filters['tahun_anggaran'],
//                $filters['status_verifikasi'],
//                $filters['status_aktif'],
//            ])
            ->deferFilters()
            ->deselectAllRecordsWhenFiltered()
            ->hiddenFilterIndicators()
            ->actions([
                Tables\Actions\Action::make('cetak ba')
                    ->label('Cetak Berita Acara')
                    ->icon('heroicon-o-printer')
                    ->url(fn($record) => route('ba.ppks', ['id' => $record, 'm' => BantuanPpks::class]), true),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
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
                        ->icon('heroicon-o-user')
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
                            TextEntry::make('jenis_pekerjaan.nama_pekerjaan')
                                ->label('Jenis Pekerjaan')
                                ->icon('heroicon-o-briefcase')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('pendidikan_terakhir.nama_pendidikan')
                                ->label('Pendidikan Terakhir')
                                ->icon('heroicon-o-academic-cap')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('hubungan_keluarga.nama_hubungan')
                                ->label('Hubungan Keluarga')
                                ->icon('heroicon-o-arrow-path')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('nama_ibu_kandung')
                                ->label('Nama Ibu Kandung')
                                ->icon('heroicon-o-user-circle')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('jenis_kelamin')
                                ->label('Jenis Kelamin')
                                ->icon('heroicon-o-user-circle')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                        ])->columns(2),
                    \Filament\Infolists\Components\Section::make('Detail Bantuan PPKS')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            TextEntry::make('detailBantuanPpks.nama_bantuan')
                                ->label('Nama Bantuan')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('detailBantuanPpks.barang.nama_barang')
                                ->label('Item Bantuan')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('detailBantuanPpks.jumlah_bantuan')
                                ->label('Jumlah Bantuan')
                                ->formatStateUsing(fn($state) => $state.' Bantuan')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('detailBantuanPpks.jenis_anggaran')
                                ->label('Jenis Anggaran')
                                ->badge(),
                            TextEntry::make('detailBantuanPpks.tahun_anggaran')
                                ->label('Tahun Anggaran')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('detailBantuanPpks.bansosDiterima.nama_bansos')
                                ->label('Bansos Yang Pernah Diterima')
                                ->badge()
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                        ])->columns(2),
                    \Filament\Infolists\Components\Section::make('Informasi Alamat')
                        ->icon('heroicon-o-map-pin')
                        ->schema([
                            TextEntry::make('alamat')
                                ->label('Alamat')
                                ->columnSpanFull()
                                ->icon('heroicon-o-map-pin')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('prov.name')
                                ->label('Provinsi'),
                            TextEntry::make('kab.name')
                                ->label('Kabupaten'),
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
                    \Filament\Infolists\Components\Section::make('Penyaluran Bantuan')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            TextEntry::make('penyaluran.status_penyaluran')
                                ->label('Status Penyaluran')
                                ->badge(),
                            TextEntry::make('penyaluran.tgl_penyerahan')
                                ->label('Tgl. Penyerahan')
                                ->date('d F Y'),
                        ])->columns(2),

                    \Filament\Infolists\Components\Section::make('Informasi Bantuan Dan Status Penerima')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            //                            TextEntry::make('nama_bantuan')
                            //                                ->label('Nama Bantuan')
                            //                                ->weight(FontWeight::SemiBold)
                            //                                ->color('primary'),
                            //                            TextEntry::make('jumlah_bantuan')
                            //                                ->label('Jumlah Bantuan')
                            //                                ->icon('heroicon-o-bookmark')
                            //                                ->weight(FontWeight::SemiBold)
                            //                                ->color('primary'),
                            //                            TextEntry::make('bansos_diterima.nama_bansos')
                            //                                ->badge()
                            //                                ->label('Bantuan Yang Pernah Diterima')
                            //                                ->weight(FontWeight::SemiBold)
                            //                                ->color('primary'),
                            TextEntry::make('tipe_ppks.nama_tipe')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary')
                                ->icon('heroicon-o-clipboard-document-list')
                                ->label('Tipe PPKS'),
                            TextEntry::make('kriteriaPpks.nama_kriteria')
                                ->listWithLineBreaks()
                                ->badge()
                                ->label('Kriteria PPKS'),
                            TextEntry::make('penghasilan_rata_rata')
                                ->label('Penghasilan Rata-Rata')
                                ->icon('heroicon-o-banknotes')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('jenis_anggaran')
                                ->label('Jenis Anggaran')
                                ->badge(),
                            TextEntry::make('tahun_anggaran')
                                ->label('Tahun Anggaran'),
                            TextEntry::make('status_rumah_tinggal')
                                ->label('Rumah Tinggal')
                                ->badge(),
                            TextEntry::make('status_kondisi_rumah')
                                ->label('Kondisi Rumah')
                                ->badge(),
                            TextEntry::make('status_verifikasi')
                                ->label('Status Verifikasi')
                                ->badge(),
                            TextEntry::make('status_aktif')
                                ->label('Status Aktif')
                                ->badge(),
                            TextEntry::make('keterangan')
                                ->label('Keterangan')
                                ->columnSpanFull()
                                ->icon('heroicon-o-bookmark')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                        ])
                        ->columns(2),

                    \Filament\Infolists\Components\Section::make('Dokumentasi')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            ImageEntry::make('bukti_foto')
                                ->hiddenLabel()
                                ->height(400)
                                ->extraImgAttributes([
                                    'alt' => 'dokumentasi',
                                    'loading' => 'lazy',
                                ]),
                        ])->columns(3),
                ])->columns(1),

            ])->columns(3);
    }


    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['nama_lengkap', 'dtks_id', 'nik', 'nokk']);
    }

    public static function getRelations(): array
    {
        return [
            //            DetailBantuanPpksRelationManager::class
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
        if (auth()->user()->hasRole(superadmin_admin_roles())) {
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
