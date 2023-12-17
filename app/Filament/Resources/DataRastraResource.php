<?php

namespace App\Filament\Resources;

use App\Enums\AlasanEnum;
use App\Enums\JenisKelaminEnum;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusRastra;
use App\Enums\StatusVerifikasiEnum;
use App\Exports\ExportBantuanRastra;
use App\Filament\Resources\DataRastraResource\Pages;
use App\Filament\Resources\DataRastraResource\RelationManagers;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Rastra;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Wallo\FilamentSelectify\Components\ToggleButton;

class DataRastraResource extends Resource
{
    protected static ?string $model = Rastra::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $slug = 'data-rastra';
    protected static ?string $label = 'Data Rastra';
    protected static ?string $pluralLabel = 'Data Rastra';
    protected static ?string $navigationGroup = 'Bantuan';
    protected static ?int $navigationSort = 5;
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
                            TextInput::make('nokk_kpm')
                                ->label('No. Kartu Keluarga (KK)')
                                ->required()
                                ->maxLength(20),
                            TextInput::make('nik_kpm')
                                ->label('N I K')
                                ->required()
                                ->maxLength(20),
                            TextInput::make('nama_kpm')
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
                            TextInput::make('no_telp')
                                ->label('No. Telp/WA')
                                ->required()
                                ->maxLength(18),

                            Select::make('jenis_kelamin')
                                ->options(JenisKelaminEnum::class)
                                ->default(JenisKelaminEnum::LAKI),

                            Select::make('hubungan_keluarga_id')
                                ->relationship('hubungan_keluarga', 'nama_hubungan')
                                ->searchable()
                                ->default(7)
                                ->optionsLimit(15)
                                ->preload(),
                            Select::make('status_kawin')
                                ->options(StatusKawinBpjsEnum::class)
                                ->default(StatusKawinBpjsEnum::KAWIN)
                                ->preload(),
                            Geocomplete::make('alamat_kpm')
                                ->required()
                                ->countries(['id'])
                                ->updateLatLng()
                                ->geocodeOnLoad()
                                ->geolocate()
                                ->columnSpanFull()
                                ->reverseGeocode([
                                    'country' => '%C',
                                    'city' => '%L',
                                    'city_district' => '%D',
                                    'zip' => '%z',
                                    'state' => '%A1',
                                    'street' => '%S %n',
                                ]),
                            Select::make('kecamatan')
                                ->required()
                                ->searchable()
                                ->reactive()
                                ->options(function () {
                                    $kab = Kecamatan::query()->where('kabupaten_code',
                                        config('custom.default.kodekab'));
                                    if (!$kab) {
                                        return Kecamatan::where('kabupaten_code', config('custom.default.kodekab'))
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
                            Grid::make(2)->schema([
                                TextInput::make('lat')
                                    ->disabled()
                                    ->dehydrated()
                                    ->reactive()
                                    ->afterStateUpdated(function (
                                        $state,
                                        callable $get,
                                        callable $set
                                    ) {
                                        $set('location', [
                                            'lat' => floatVal($state),
                                            'lng' => floatVal($get('lng')),
                                        ]);
                                    })
                                    ->lazy(), // important to use lazy, to avoid updates as you type
                                TextInput::make('lng')
                                    ->disabled()
                                    ->dehydrated()
                                    ->reactive()
                                    ->afterStateUpdated(function (
                                        $state,
                                        callable $get,
                                        callable $set
                                    ) {
                                        $set('location', [
                                            'lat' => (float) $get('lat'),
                                            'lng' => floatVal($state),
                                        ]);
                                    })
                                    ->lazy(),
                            ]),
                        ])->columns(2),
                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Section::make('Status & Waktu Penyerahan')
                        ->schema([
                            Select::make('jenis_bantuan_id')
                                ->required()
                                ->searchable()
                                ->disabled()
                                ->hidden()
                                ->relationship(
                                    name: 'jenis_bantuan',
                                    titleAttribute: 'alias',
                                    modifyQueryUsing: fn(Builder $query) => $query->whereNotIn('id', [1, 2])
                                )
                                ->default(5)
                                ->dehydrated(),

                            Forms\Components\DateTimePicker::make('tgl_penyerahan')
                                ->label('Tgl. Penyerahan')
                                ->disabled()
                                ->displayFormat('d/M/Y H:i:s')
                                ->default(now())
                                ->dehydrated(),

                            Select::make('status_verifikasi')
                                ->label('Status Verifikasi')
                                ->options(StatusVerifikasiEnum::class)
                                ->default(StatusVerifikasiEnum::UNVERIFIED)
                                ->preload()
                                ->visible(fn() => auth()->user()?->hasRole(['super_admin', 'admin'])),

                            Select::make('status_penyerahan')
                                ->label('Status Rastra')
                                ->enum(StatusRastra::class)
                                ->options(StatusRastra::class)
                                ->default(StatusRastra::BARU)
                                ->live()
                                ->preload(),

                            Select::make('pengganti_rastra.keluarga_id')
                                ->label('Keluarga Yang Diganti')
                                ->required()
                                ->options(Rastra::query()
                                    ->where('status_penyerahan', StatusRastra::BARU)
                                    ->pluck('nama_kpm', 'id'))
                                ->searchable(['nama_lengkap', 'nik', 'nokk'])
                                ->optionsLimit(15)
                                ->lazy()
                                ->visible(fn(Get $get) => $get('status_penyerahan') === StatusRastra::PENGGANTI)
                                ->preload(),

                            Select::make('pengganti_rastra.alasan_dikeluarkan')
                                ->searchable()
                                ->options(AlasanEnum::class)
                                ->enum(AlasanEnum::class)
                                ->native(false)
                                ->preload()
                                ->lazy()
                                ->required()
                                ->visible(fn(Get $get) => $get('status_penyerahan') === StatusRastra::PENGGANTI)
                                ->default(AlasanEnum::PINDAH)
                                ->optionsLimit(15),

                            ToggleButton::make('status_aktif')
                                ->label('Status Aktif')
                                ->offColor('danger')
                                ->onColor('primary')
                                ->offLabel('Non Aktif')
                                ->onLabel('Aktif')
                                ->default(true),
                        ]),

                    Forms\Components\Section::make('Verifikasi Data')
                        ->schema([
                            FileUpload::make('foto_penyerahan')
                                ->label('Unggah Foto Penyerahan ')
                                ->getUploadedFileNameForStorageUsing(
                                    fn(TemporaryUploadedFile $file
                                    ): string => (string) str($file->getClientOriginalName())
                                        ->prepend(date('YmdHis') . '-'),
                                )
                                ->preserveFilenames()
//                                ->multiple()
                                ->reorderable()
                                ->appendFiles()
                                ->openable()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->helperText('maks. 2MB')
                                ->maxFiles(3)
                                ->maxSize(2048)
                                ->columnSpanFull()
                                ->imagePreviewHeight('250')
                                ->previewable(false)
                                ->image(),
                            FileUpload::make('foto_ktp_kk')
                                ->label('Unggah Foto Pegang KTP/KK')
                                ->getUploadedFileNameForStorageUsing(
                                    fn(TemporaryUploadedFile $file
                                    ): string => (string) str($file->getClientOriginalName())
                                        ->prepend(date('YmdHis') . '-'),
                                )
                                ->preserveFilenames()
//                                ->multiple()
                                ->reorderable()
                                ->appendFiles()
                                ->openable()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->helperText('maks. 2MB')
                                ->maxFiles(3)
                                ->maxSize(2048)
                                ->columnSpanFull()
                                ->imagePreviewHeight('250')
                                ->previewable(false)
                                ->image(),
                        ]),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                MapColumn::make('location')
                    ->label('Lokasi')
                    ->height('80')
                    ->width('100')
                    ->type('hybrid')
                    ->zoom(15)
                    ->ttl(60 * 60 * 24 * 30),
                Tables\Columns\TextColumn::make('dtks_id')
                    ->label('DTKS ID')
                    ->description(fn($record) => $record->nama_kpm)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_kpm')
                    ->label('NIK KPM')
                    ->sortable()
                    ->searchable()
                    ->description(fn($record) => 'No.KK : ' . $record->nokk_kpm),
                Tables\Columns\TextColumn::make('no_telp')
                    ->label('TELP/HP')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('alamat_kpm')
                    ->label('ALAMAT')
                    ->words(5)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->label('Tempat/Tgl Lahir')
                    ->alignCenter()
                    ->formatStateUsing(fn($record) => $record->tempat_lahir . ', ' . $record->tgl_lahir)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->badge(),
                Tables\Columns\TextColumn::make('status_penyerahan')
                    ->label('Status Rastra')
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->badge(),

            ])
            ->filters([
                SelectFilter::make('kecamatan')
                    ->label('Kecamatan')
                    ->options(Kecamatan::query()->where('kabupaten_code',
                        config('custom.default.kodekab'))->pluck('name', 'code'))
                    ->preload()
                    ->searchable(),
                SelectFilter::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->options(StatusVerifikasiEnum::class)
                    ->searchable(),
                SelectFilter::make('status_penyerahan')
                    ->label('Status Rastra')
                    ->options(StatusRastra::class)
                    ->searchable(),
                DateRangeFilter::make('created_at')
                    ->label('Rentang Tanggal'),
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
                        ->label('Ekspor XLS')
                        ->exports([
                            ExportBantuanRastra::make()
                        ]),
                ]),
            ]);
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
            'index' => Pages\ListDataRastra::route('/'),
            'create' => Pages\CreateDataRastra::route('/create'),
            'view' => Pages\ViewDataRastra::route('/{record}'),
            'edit' => Pages\EditDataRastra::route('/{record}/edit'),
        ];
    }
}
