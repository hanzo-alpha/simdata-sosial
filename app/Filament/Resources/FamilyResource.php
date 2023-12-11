<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Exports\ExportKeluarga;
use App\Filament\Resources\FamilyResource\Pages;
use App\Filament\Resources\FamilyResource\RelationManagers;
use App\Filament\Resources\FamilyResource\Widgets\FamilyOverview;
use App\Forms\Components\AlamatForm;
use App\Models\Family;
use Filament\Forms;
use Filament\Forms\Components\Select;
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
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Wallo\FilamentSelectify\Components\ToggleButton;

class FamilyResource extends Resource
{
    protected static ?string $model = Family::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $slug = 'family';
    protected static ?string $label = 'Keluarga';
    protected static ?string $pluralLabel = 'Keluarga';


    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Data Keluarga')
                        ->schema([
                            Forms\Components\TextInput::make('dtks_id')
                                ->maxLength(36)
                                ->hidden()
                                ->dehydrated()
                                ->columnSpanFull()
                                ->default(\Str::uuid()->toString()),
                            Forms\Components\TextInput::make('nokk')
                                ->label('No. Kartu Keluarga (KK)')
                                ->required()
                                ->maxLength(20),
                            Forms\Components\TextInput::make('nik')
                                ->label('N I K')
                                ->required()
                                ->maxLength(20),
                            Forms\Components\TextInput::make('nama_lengkap')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('nama_ibu_kandung')
                                ->label('Nama Ibu Kandung')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('tempat_lahir')
                                ->label('Tempat Lahir')
                                ->required()
                                ->maxLength(50),
                            Forms\Components\DatePicker::make('tgl_lahir')
                                ->displayFormat('d/M/Y')
                                ->label('Tgl. Lahir')
                                ->required(),
                            Forms\Components\TextInput::make('notelp')
                                ->label('No. Telp/WA')
                                ->required()
                                ->maxLength(18),

                            Forms\Components\Select::make('jenis_kelamin')
                                ->options(JenisKelaminEnum::class)
                                ->default(JenisKelaminEnum::LAKI),
                        ])->columns(2),

                    Forms\Components\Section::make('Data Alamat')
                        ->schema([
                            AlamatForm::make('alamat')
                        ]),
                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Data Pendukung')
                        ->schema([
//                            BantuanForm::make('bantuan'),
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
                            Forms\Components\Select::make('jenis_pekerjaan_id')
                                ->relationship('jenis_pekerjaan', 'nama_pekerjaan')
                                ->searchable()
                                ->optionsLimit(15)
                                ->default(6)
                                ->preload(),
                            Forms\Components\Select::make('pendidikan_terakhir_id')
                                ->relationship('pendidikan_terakhir', 'nama_pendidikan')
                                ->searchable()
                                ->default(5)
                                ->optionsLimit(15)
                                ->preload(),
                            Forms\Components\Select::make('hubungan_keluarga_id')
                                ->relationship('hubungan_keluarga', 'nama_hubungan')
                                ->searchable()
                                ->default(7)
                                ->optionsLimit(15)
                                ->preload(),
                        ]),
                    Forms\Components\Section::make('Status')
                        ->schema([
                            Forms\Components\Select::make('status_kawin')
                                ->label('Status Kawin')
                                ->options(StatusKawinBpjsEnum::class)
                                ->default(StatusKawinBpjsEnum::KAWIN)
                                ->preload(),

                            Forms\Components\Select::make('status_verifikasi')
                                ->label('Status Verifikasi')
                                ->options(StatusVerifikasiEnum::class)
                                ->default(StatusVerifikasiEnum::UNVERIFIED)
                                ->preload(),

                            ToggleButton::make('status_family')
                                ->label('Status Aktif')
                                ->offColor('danger')
                                ->onColor('primary')
                                ->offLabel('Non Aktif')
                                ->onLabel('Aktif')
                                ->default(true),
                        ]),
                ])->columns(1),
//                Forms\Components\Section::make('Verifikasi Rumah')
//                    ->schema([
//                        Forms\Components\FileUpload::make('foto')
//                            ->label('Unggah Foto Rumah')
//                            ->getUploadedFileNameForStorageUsing(
//                                fn(TemporaryUploadedFile $file
//                                ): string => (string) str($file->getClientOriginalName())
//                                    ->prepend(date('d-m-Y-H-i-s') . '-'),
//                            )
//                            ->preserveFilenames()
//                            ->multiple()
//                            ->reorderable()
//                            ->appendFiles()
//                            ->openable()
//                            ->required()
//                            ->unique(ignoreRecord: true)
//                            ->helperText('maks. 2MB')
//                            ->maxFiles(3)
//                            ->maxSize(2048)
//                            ->columnSpanFull()
//                            ->imagePreviewHeight('250')
//                            ->previewable(false)
//                            ->image()
//                            ->imageEditor()
//                            ->imageEditorAspectRatios([
//                                '16:9',
//                                '4:3',
//                                '1:1',
//                            ])
//                    ]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('dtks_id')
                    ->label('DTKS ID')
                    ->description(fn($record) => $record->nama_lengkap)
                    ->limit(14)
                    ->searchable(),
                Tables\Columns\TextColumn::make('nokk')
                    ->label('No. KK / NIK')
                    ->description(fn($record) => $record->nik)
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->label('Tempat Tgl Lahir')
                    ->formatStateUsing(fn($record) => $record->tempat_lahir . ', ' . $record->tgl_lahir->locale('id')
                            ->format('d M Y')
                    )
                    ->searchable(),
                Tables\Columns\TextColumn::make('notelp')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat.alamat_lengkap')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_ibu_kandung')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('pendidikan_terakhir.nama_pendidikan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('hubungan_keluarga.nama_hubungan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_kawin')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge(),
                Tables\Columns\TextColumn::make('status_verifikasi')
                    ->label('Verifikasi Rumah')
                    ->badge(),
                Tables\Columns\TextColumn::make('status_family')
                    ->label('Status')
                    ->badge(),
            ])
            ->filters([
//                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('jenis_bantuan_id')
                    ->label('Jenis Bantuan')
                    ->relationship('jenis_bantuan', 'alias')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('status_kawin')
                    ->label('Status Kawin')
                    ->options(StatusKawinBpjsEnum::class)
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
                    Tables\Actions\DeleteAction::make()
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    ExportBulkAction::make()
                        ->label('Ekspor Ke Excel')
                        ->exports([
                            ExportKeluarga::make()
                        ]),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Keluarga')
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
                        TextEntry::make('alamat_penerima')
                            ->label('Alamat')
                            ->icon('heroicon-o-map-pin')
                            ->weight(FontWeight::SemiBold)
                            ->color('primary'),
                    ])->columns(3),

                Section::make('Informasi Alamat')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                TextEntry::make('alamat_lengkap_penerima')
                                    ->label('Alamat')
                                    ->icon('heroicon-o-map-pin')
                                    ->weight(FontWeight::SemiBold)
                                    ->color('primary'),
                            ]),
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('kec.name')
                                    ->label('Kecamatan'),
                                TextEntry::make('kel.name')
                                    ->label('Kelurahan'),
                                TextEntry::make('latitude')
                                    ->label('Latitude'),
                                TextEntry::make('longitude')
                                    ->label('Longitude'),
                            ]),
                    ])->columns(3),

                Section::make('Informasi Bantuan')
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
        return static::$model::where('status_family', StatusAktif::AKTIF)->count();
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['alamat', 'jenis_bantuan']);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            FamilyOverview::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFamilies::route('/'),
            'create' => Pages\CreateFamily::route('/create'),
            'view' => Pages\ViewFamily::route('/{record}'),
            'edit' => Pages\EditFamily::route('/{record}/edit'),
        ];
    }
}
