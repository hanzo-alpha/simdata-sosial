<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusKawinEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Exports\ExportKeluarga;
use App\Filament\Resources\KeluargaResource\Pages;
use App\Forms\Components\AlamatForm;
use App\Forms\Components\PpksForm;
use App\Models\Keluarga;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use EightyNine\Approvals\Tables\Columns\ApprovalStatusColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Wallo\FilamentSelectify\Components\ToggleButton;

class KeluargaResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Keluarga::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $slug = 'penerima-manfaat';
    protected static ?string $label = 'Penerima Manfaat';
    protected static ?string $pluralLabel = 'Penerima Manfaat';

//    protected static ?string $navigationGroup = 'Master';

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'force_delete',
            'verify'
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema(static::getFormSchema()),
                        Forms\Components\Section::make('Alamat Keluarga')
                            ->schema(static::getFormSchema('alamat')),
                        Forms\Components\Section::make('Data Lainnya')
                            ->schema(static::getFormSchema('lainnya'))->columns(2),
                        Forms\Components\Section::make('Unggah Data')
                            ->schema(static::getFormSchema('upload')),
                    ])
                    ->columnSpan(['lg' => fn(?Keluarga $record) => $record === null ? 3 : 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('unggah_foto')
                    ->label('Foto Rumah')
//                    ->square()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText(true),
                Tables\Columns\TextColumn::make('dtks_id')
                    ->label('DTKS ID')
                    ->description(fn($record) => $record->nama_lengkap)
                    ->sortable()
//                    ->limit(10)
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK & NO. KK')
                    ->toggleable()
                    ->description(fn($record) => 'No. KK : ' . $record->nokk)
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->label('TTL')
                    ->formatStateUsing(fn($state, $record) => $state . ', ' . $record->tgl_lahir->format('d/m/Y'))
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('notelp')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('nama_ibu_kandung')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\IconColumn::make('jenis_kelamin')
                    ->boolean()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('alamat.kec.name')
                    ->label('Kecamatan')
                    ->description(fn($record) => 'Kel. ' . $record->alamat->kel->name)
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_bantuan.alias')
                    ->label('Alias')
                    ->badge()
                    ->color(fn($record) => $record->jenis_bantuan->warna)
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('pendidikan_terakhir.nama_pendidikan')
                    ->label('Pendidikan')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('hubungan_keluarga.nama_hubungan')
                    ->label('Hubungan Keluarga')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('jenis_pekerjaan.nama_pekerjaan')
                    ->label('Pekerjaan')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\IconColumn::make('status_kawin')
                    ->label('Status Kawin')
                    ->boolean()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->badge(),
                Tables\Columns\IconColumn::make('status_keluarga')
                    ->label('Status Aktif')
                    ->boolean()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->filters([
                SelectFilter::make('jenis_bantuan_id')
                    ->label('Jenis Bantuan')
                    ->relationship('jenis_bantuan', 'alias')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('status_kawin')
                    ->label('Status Kawin')
                    ->options(StatusKawinEnum::class)
                    ->searchable(),
                SelectFilter::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->options(StatusVerifikasiEnum::class)
                    ->searchable(),
                SelectFilter::make('status_keluarga')
                    ->label('Status Aktif')
                    ->options(StatusAktif::class)
                    ->searchable(),

            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->persistFiltersInSession()
            ->deselectAllRecordsWhenFiltered()
            ->actions([
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
                            ExportKeluarga::make()
                        ]),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
//            RelationManagers\AddressesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKeluarga::route('/'),
            'create' => Pages\CreateKeluarga::route('/create'),
            'view' => Pages\ViewKeluarga::route('/{record}'),
            'edit' => Pages\EditKeluarga::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Data Pribadi')
                    ->description('Berisi informasi dasar keluarga')
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
                            ->date('d F Y')
                            ->icon('heroicon-o-calendar')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                        TextEntry::make('alamat.full_address')
                            ->label('Alamat')
                            ->icon('heroicon-o-map-pin')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                    ])->columns(3),

                Section::make('Data Alamat')
                    ->description('Berisi informasi tentang alamat dan lokasi keluarga')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('alamat.full_address')
                                    ->label('Alamat'),
                                TextEntry::make('alamat.kec.name')
                                    ->label('Kecamatan'),
                                TextEntry::make('alamat.kel.name')
                                    ->label('Kelurahan'),
//                                TextEntry::make('alamat.full_address')
//                                    ->label('Alamat Lengkap'),
//                                TextEntry::make('alamat.latitude')
//                                    ->label('Latitude'),
//                                TextEntry::make('alamat.longitude')
//                                    ->label('longitude'),
                            ]),
//                        Grid::make(4)
//                            ->schema([
//                                TextEntry::make('alamat.prov.name')
//                                    ->label('Provinsi'),
//                                TextEntry::make('alamat.kab.name')
//                                    ->label('Kabupaten'),
//                                TextEntry::make('alamat.kec.name')
//                                    ->label('Kecamatan'),
//                                TextEntry::make('alamat.kel.name')
//                                    ->label('Kelurahan'),
//                            ]),

//                        Grid::make(4)->schema([
//                            TextEntry::make('alamat.dusun')
//                                ->label('Dusun'),
//                            TextEntry::make('alamat.no_rt')
//                                ->label('No. RT'),
//                            TextEntry::make('alamat.no_rw')
//                                ->label('No. RW'),
//                            TextEntry::make('alamat.kodepos')
//                                ->label('Kode Pos'),
//                        ])
                    ])->columns(3),

                Section::make('Data Pendukung')
                    ->schema([
                        TextEntry::make('jenis_bantuan.nama_bantuan')
                            ->label('Jenis Bantuan')
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
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('status_kawin')
                                    ->label('Status Kawin')
                                    ->badge(),
                                TextEntry::make('status_verifikasi')
                                    ->label('Verifikasi Berkas/Foto')
                                    ->badge(),
                                TextEntry::make('status_keluarga')
                                    ->label('Status Aktif')
                                    ->badge(),
                            ]),
                    ])
                    ->columns(3),

                Section::make('Foto Rumah')
                    ->schema([
                        ImageEntry::make('unggah_foto')
                            ->hiddenLabel()
                            ->visibility('private')
                            ->columnSpanFull()
//                            ->width(800)
//                            ->height(600)
//                            ->size(400)
                            ->extraImgAttributes([
                                'alt' => 'foto rumah',
                                'loading' => 'lazy'
                            ])
                            ->limit(3)
                            ->limitedRemainingText()
                    ])->columns(3)

            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::$model::where('status_keluarga', StatusAktif::AKTIF)->count();
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['alamat', 'jenis_bantuan']);
    }

    public static function getFormSchema(string $section = null): array
    {
        if ($section === 'lainnya') {
            return [
                Forms\Components\Select::make('jenis_bantuan_id')
                    ->required()
                    ->searchable()
                    ->relationship(
                        name: 'jenis_bantuan',
                        titleAttribute: 'alias',
                        modifyQueryUsing: fn(Builder $query) => $query->whereNotIn('id', [1, 2])
                    )
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        return '<strong>' . $record->alias . '</strong><br>' . $record->nama_bantuan;
                    })->allowHtml()
                    ->preload()
                    ->default(4)
                    ->lazy()
                    ->native(false)
                    ->optionsLimit(20),
                Forms\Components\Select::make('pendidikan_terakhir_id')
                    ->required()
                    ->searchable()
                    ->relationship('pendidikan_terakhir', 'nama_pendidikan')
                    ->preload()
                    ->default(5)
                    ->lazy()
                    ->optionsLimit(20),
                Forms\Components\Select::make('hubungan_keluarga_id')
                    ->required()
                    ->searchable()
                    ->relationship('hubungan_keluarga', 'nama_hubungan')
                    ->preload()
                    ->lazy()
                    ->default(1)
                    ->optionsLimit(20),
                Forms\Components\Select::make('jenis_pekerjaan_id')
                    ->required()
                    ->searchable()
                    ->relationship('jenis_pekerjaan', 'nama_pekerjaan')
                    ->default(6)
                    ->preload()
                    ->lazy()
                    ->optionsLimit(20),
                Forms\Components\TextInput::make('nama_ibu_kandung')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status_kawin')
                    ->searchable()
                    ->options(StatusKawinEnum::class)
                    ->default(StatusKawinEnum::KAWIN),
                Forms\Components\Select::make('jenis_kelamin')
                    ->options(JenisKelaminEnum::class)
                    ->default(JenisKelaminEnum::LAKI),
                Forms\Components\Select::make('status_verifikasi')
                    ->options(StatusVerifikasiEnum::class)
                    ->default(StatusVerifikasiEnum::UNVERIFIED)
                    ->visible(fn() => auth()->user()?->hasRole(['super_admin', 'admin'])),
                ToggleButton::make('status_keluarga')
                    ->offColor('danger')
                    ->onColor('primary')
                    ->offLabel('Non Aktif')
                    ->onLabel('Aktif')
                    ->default(true),
            ];
        }

        if ($section === 'ppks') {
            return [
                PpksForm::make('ppks')
            ];
        }

        if ($section === 'alamat') {
            return [
                AlamatForm::make('alamat')
                    ->columnSpan('full'),
            ];
        }

        if ($section === 'upload') {
            return [
                Forms\Components\Grid::make()->schema([
                    Forms\Components\FileUpload::make('unggah_foto')
                        ->label('Unggah Foto Rumah')
                        ->getUploadedFileNameForStorageUsing(
                            fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                ->prepend(date('d-m-Y-H-i-s') . '-'),
                        )
                        ->preserveFilenames()
                        ->multiple()
                        ->reorderable()
                        ->appendFiles()
                        ->openable()
                        ->required()
                        ->helperText('maks. 2MB')
                        ->maxFiles(3)
                        ->maxSize(2048)
                        ->columnSpanFull()
                        ->imagePreviewHeight('250')
                        ->image()
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                        ]),
                ])

            ];
        }

        return [
            Forms\Components\TextInput::make('nokk')
                ->label('No. Kartu Keluarga')
                ->autofocus()
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(20),
            Forms\Components\TextInput::make('nik')
                ->label('Nomor Induk Kependudukan (NIK)')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(20),
            Forms\Components\TextInput::make('nama_lengkap')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('notelp')
                ->label('No. Telp/HP')
                ->tel()
                ->required()
                ->maxLength(18),
            Forms\Components\TextInput::make('tempat_lahir')
                ->label('Tempat Lahir')
                ->required()
                ->maxLength(50),
            Forms\Components\DatePicker::make('tgl_lahir')
                ->label('Tanggal Lahir')
                ->displayFormat('d/m/Y')
                ->required(),
        ];
    }
}
