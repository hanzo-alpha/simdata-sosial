<?php

namespace App\Filament\Resources;

use App\Enums\AlasanEnum;
use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusBpjsEnum;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusRastra;
use App\Enums\StatusVerifikasiEnum;
use App\Exports\ExportBantuanBpjs;
use App\Filament\Resources\BantuanBpjsResource\Pages;
use App\Filament\Resources\BantuanBpjsResource\RelationManagers;
use App\Forms\Components\AlamatForm;
use App\Forms\Components\FamilyForm;
use App\Models\BantuanBpjs;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
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

class BantuanBpjsResource extends Resource
{
    protected static ?string $model = BantuanBpjs::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $slug = 'bantuan-bpjs';
    protected static ?string $label = 'Bantuan BPJS';
    protected static ?string $pluralLabel = 'Bantuan BPJS';
    protected static ?string $navigationLabel = 'Bantuan BPJS';
    protected static ?string $navigationGroup = 'Bantuan';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Data Keluarga')
                        ->schema([
                            TextInput::make('dtks_id')
                                ->maxLength(36)
                                ->hidden()
                                ->dehydrated()
                                ->default(\Str::uuid()->toString()),
                            TextInput::make('nokk')
                                ->label('No. Kartu Keluarga (KK)')
                                ->required()
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
                            TextInput::make('notelp')
                                ->label('No. Telp/WA')
                                ->required()
                                ->maxLength(18),

                            Select::make('jenis_kelamin')
                                ->options(JenisKelaminEnum::class)
                                ->default(JenisKelaminEnum::LAKI),

                            Select::make('jenis_pekerjaan_id')
                                ->relationship('jenis_pekerjaan', 'nama_pekerjaan')
                                ->searchable()
                                ->optionsLimit(15)
                                ->default(6)
                                ->preload(),
                            Select::make('pendidikan_terakhir_id')
                                ->relationship('pendidikan_terakhir', 'nama_pendidikan')
                                ->searchable()
                                ->default(5)
                                ->optionsLimit(15)
                                ->preload(),
                            Select::make('hubungan_keluarga_id')
                                ->relationship('hubungan_keluarga', 'nama_hubungan')
                                ->searchable()
                                ->default(1)
                                ->optionsLimit(15)
                                ->preload(),
                            Select::make('status_kawin')
                                ->options(StatusKawinBpjsEnum::class)
                                ->default(StatusKawinBpjsEnum::BELUM_KAWIN)
                                ->preload(),

                        ])->columns(2),
//                    FamilyForm::make('family'),
                    Section::make('Data Alamat')
                        ->schema([
                            AlamatForm::make('alamat')
                        ]),
                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Section::make('Status')
                        ->schema([
                            Select::make('jenis_bantuan_id')
                                ->required()
                                ->searchable()
                                ->disabled()
                                ->relationship(
                                    name: 'jenis_bantuan',
                                    titleAttribute: 'alias',
                                    modifyQueryUsing: fn(Builder $query) => $query->whereNotIn('id', [1, 2])
                                )
                                ->default(3)
                                ->dehydrated(),

                            Select::make('status_verifikasi')
                                ->label('Status Verifikasi')
                                ->options(StatusVerifikasiEnum::class)
                                ->default(StatusVerifikasiEnum::UNVERIFIED)
                                ->preload()
                                ->visible(fn() => auth()->user()?->hasRole(['super_admin', 'admin'])),


                            Forms\Components\Select::make('status_bpjs')
                                ->label('Status BPJS')
                                ->enum(StatusBpjsEnum::class)
                                ->options(StatusBpjsEnum::class)
                                ->default(StatusBpjsEnum::PENGAKTIFAN)
                                ->live()
                                ->preload(),

                            Select::make('mutasi.keluarga_id')
                                ->label('Keluarga Yang Diganti')
                                ->required()
                                ->options(BantuanBpjs::query()->where('status_bpjs',
                                    StatusBpjsEnum::PENGAKTIFAN)->pluck('nama_lengkap', 'id'))
                                ->searchable(['nama_lengkap', 'nik', 'nokk'])
//                                ->getOptionLabelFromRecordUsing(function ($record) {
//                                    return '<strong>' . $record->family->nama_lengkap . '</strong><br>' . $record->nik;
//                                })->allowHtml()
                                ->optionsLimit(15)
                                ->lazy()
                                ->visible(fn(Get $get) => $get('status_bpjs') === StatusBpjsEnum::PENGAKTIFAN)
                                ->preload(),

                            Select::make('mutasi.alasan_dimutasi')
                                ->searchable()
                                ->options(AlasanEnum::class)
                                ->enum(AlasanEnum::class)
                                ->native(false)
                                ->preload()
                                ->lazy()
                                ->required()
                                ->visible(fn(Get $get) => $get('status_bpjs') === StatusBpjsEnum::PENGAKTIFAN)
                                ->default(AlasanEnum::PINDAH)
                                ->optionsLimit(15),

                            ToggleButton::make('status_aktif')
                                ->label('Status Aktif')
                                ->offColor(StatusAktif::NONAKTIF->getColor())
                                ->onColor(StatusAktif::AKTIF->getColor())
                                ->offLabel(StatusAktif::NONAKTIF->getLabel())
                                ->onLabel(StatusAktif::AKTIF->getLabel())
                                ->default(0),
                        ]),
//                    Forms\Components\Section::make('Verifikasi')
//                        ->schema([
//                            Forms\Components\FileUpload::make('bukti_foto')
//                                ->label('Unggah Foto Rumah')
//                                ->getUploadedFileNameForStorageUsing(
//                                    fn(TemporaryUploadedFile $file
//                                    ): string => (string) str($file->getClientOriginalName())
//                                        ->prepend(date('d-m-Y-H-i-s') . '-'),
//                                )
//                                ->preserveFilenames()
//                                ->multiple()
//                                ->reorderable()
//                                ->appendFiles()
//                                ->openable()
//                                ->required()
//                                ->unique(ignoreRecord: true)
//                                ->helperText('maks. 2MB')
//                                ->maxFiles(3)
//                                ->maxSize(2048)
//                                ->columnSpanFull()
//                                ->imagePreviewHeight('250')
//                                ->previewable(false)
//                                ->image()
//                                ->imageEditor()
//                                ->imageEditorAspectRatios([
//                                    '16:9',
//                                    '4:3',
//                                    '1:1',
//                                ]),
//
//
//                        ])
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                Tables\Columns\TextColumn::make('jenis_bantuan.alias')
                    ->label('Jenis Bantuan')
                    ->badge()
                    ->color(fn($record): string => $record->jenis_bantuan->warna)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_bpjs')
                    ->label('Status BPJS')
                    ->badge(),
                Tables\Columns\TextColumn::make('status_aktif')
                    ->label('Status Aktif')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('jenis_bantuan_id')
                    ->label('Jenis Bantuan')
                    ->relationship('jenis_bantuan', 'alias')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->options(StatusVerifikasiEnum::class)
                    ->searchable(),
                SelectFilter::make('status_bpjs')
                    ->label('Status Bpjs')
                    ->options(StatusBpjsEnum::class)
                    ->searchable(),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->persistFiltersInSession()
            ->deselectAllRecordsWhenFiltered()
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->label('Ekspor Ke Excel')
                        ->exports([
                            ExportBantuanBpjs::make()
                        ]),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Group::make([
                    \Filament\Infolists\Components\Section::make('Informasi Keluarga')
                        ->schema([
                            TextEntry::make('dtks_id')
                                ->label('DTKS ID')
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
                            TextEntry::make('notelp')
                                ->label('No. Telp/WA')
                                ->icon('heroicon-o-device-phone-mobile')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('tempat_lahir')
                                ->label('Tempat Lahir')
                                ->weight(FontWeight::SemiBold)
                                ->icon('heroicon-o-home')
                                ->color('primary'),
                            TextEntry::make('tgl_lahir')
                                ->label('Tanggal Lahir')
                                ->formatStateUsing(function ($record) {
                                    $tglLahir = Carbon::parse($record->tgl_lahir);
                                    $umur = hitung_umur($tglLahir);

                                    $tgl = $tglLahir->format('d F Y');
                                    return $tgl . ' (' . $umur . ' tahun)';
                                })
                                ->icon('heroicon-o-calendar')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('alamat.alamat')
                                ->label('Alamat')
                                ->icon('heroicon-o-map-pin')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                        ])->columns(2),
                    \Filament\Infolists\Components\Section::make('Informasi Alamat')
                        ->schema([
                            TextEntry::make('alamat.alamat_lengkap')
                                ->label('Alamat Lengkap')
                                ->columnSpanFull()
                                ->icon('heroicon-o-map-pin')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('alamat.kec.name')
                                ->label('Kecamatan'),
                            TextEntry::make('alamat.kel.name')
                                ->label('Kelurahan'),
                            TextEntry::make('alamat.latitude')
                                ->label('Latitude')
                                ->state('-'),
                            TextEntry::make('alamat.longitude')
                                ->label('Longitude')
                                ->state('-'),
                        ])->columns(2),
                ])->columnSpan(2),

                \Filament\Infolists\Components\Group::make([
//                    \Filament\Infolists\Components\Section::make('Foto Rumah')
//                        ->schema([
//                            ImageEntry::make('bukti_foto')
//                                ->hiddenLabel()
//                                ->visibility('private')
//                                ->extraImgAttributes([
//                                    'alt' => 'foto rumah',
//                                    'loading' => 'lazy'
//                                ])
//                        ])->columns(3),

                    \Filament\Infolists\Components\Section::make('Informasi Bantuan Dan Status Penerima')
                        ->schema([
                            TextEntry::make('jenis_bantuan.alias')
                                ->label('Jenis Bantuan')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('jenis_pekerjaan.nama_pekerjaan')
                                ->label('Jenis Pekerjaan')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('pendidikan_terakhir.nama_pendidikan')
                                ->label('Pendidikan Terakhir')
//                                ->icon('heroicon-o-academic-cap')
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
                                ->badge(),
                            TextEntry::make('status_kawin')
                                ->label('Status Kawin')
                                ->badge(),
                            TextEntry::make('status_verifikasi')
                                ->label('Verifikasi Berkas/Foto')
                                ->badge(),
                            TextEntry::make('status_bpjs')
                                ->label('Status BPJS')
                                ->badge(),
                            TextEntry::make('status_aktif')
                                ->label('Status Aktif')
                                ->badge(),
                        ])
                        ->columns(2),
                ])->columns(1),

            ])->columns(3);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::$model::where('status_aktif', StatusAktif::AKTIF)->count();
    }

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
