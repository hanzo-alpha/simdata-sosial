<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\AlasanEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusDtksEnum;
use App\Enums\StatusRastra;
use App\Enums\StatusVerifikasiEnum;
use App\Exports\ExportBantuanRastra;
use App\Filament\Resources\BantuanRastraResource\Pages;
use App\Filament\Resources\BantuanRastraResource\Widgets\BantuanRastraOverview;
use App\Models\BantuanRastra;
use App\Rules\NikValidationRule;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use BackedEnum;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\Width;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use UnitEnum;

class BantuanRastraResource extends Resource
{
    protected static ?string $model = BantuanRastra::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-share';
    protected static ?string $slug = 'program-rastra';
    protected static ?string $label = 'Program Rastra';
    protected static ?string $pluralLabel = 'Program Rastra';
    protected static string|UnitEnum|null $navigationGroup = 'Program Bantuan';
    protected static ?int $navigationSort = 4;
    protected static ?string $recordTitleAttribute = 'nama_lengkap';

    public static function getGloballySearchableAttributes(): array
    {
        return ['nik', 'no_kk', 'nama_lengkap'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'NIK' => $record->nik,
            'Kecamatan' => $record->kec?->name,
            'Kelurahan' => $record->kel?->name,
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll()
            ->deferLoading()
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada bantuan RASTRA')
            ->emptyStateActions([
                Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->disabled(fn(): bool => cek_batas_input(setting('app.batas_tgl_input_rastra')))
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->description(fn($record) => Str::mask($record->nik, '*', 2, 12))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nokk')
                    ->label('No. KK')
                    ->alignCenter()
                    ->searchable()
                    ->formatStateUsing(fn($state) => Str::mask($state, '*', 2, 12))
                    ->copyable()
                    ->summarize([
                        Tables\Columns\Summarizers\Count::make(),
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('N I K')
                    ->alignCenter()
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(fn($state) => Str::mask($state, '*', 2, 12))
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->sortable()
                    ->toggleable()
                    ->description(fn($record): string => 'Kec. ' . $record->kec->name . ' Kel. ' . $record->kel->name)
                    ->searchable(),
                Tables\Columns\TextColumn::make('kec.name')
                    ->label('Kecamatan')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kel.name')
                    ->label('Kelurahan')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_rastra')
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->label('Status Rastra')
                    ->badge(),
                Tables\Columns\TextColumn::make('status_verifikasi')
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->label('Status Verifikasi')
                    ->badge(),
                Tables\Columns\TextColumn::make('status_aktif')
                    ->alignCenter()
                    ->toggleable()
                    ->label('Status Aktif')
                    ->sortable()
                    ->badge(),
            ])
            ->filters([
                Tables\Filters\Filter::make('keckel')
                    ->indicator('Wilayah')
                    ->schema([
                        Select::make('kecamatan')
                            ->options(get_kecamatan_options())
                            ->live()
                            ->searchable()
                            ->native(false)
                            ->columnSpanFull(),
                        Select::make('kelurahan')
                            ->options(fn(callable $get) => get_kelurahan_options($get('kecamatan')))
                            ->searchable()
                            ->native(false)
                            ->columnSpanFull(),
                    ])
                    ->query(fn(Builder $query, array $data): Builder => $query
                        ->when(
                            $data['kecamatan'],
                            fn(Builder $query, $data): Builder => $query->where('kecamatan', $data),
                        )
                        ->when(
                            $data['kelurahan'],
                            fn(Builder $query, $data): Builder => $query->where('kelurahan', $data),
                        )),
                SelectFilter::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->options(StatusVerifikasiEnum::class)
                    ->native(false)
                    ->searchable(),
                SelectFilter::make('status_rastra')
                    ->label('Status Rastra')
                    ->options(StatusRastra::class)
                    ->native(false)
                    ->searchable(),
                SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(list_tahun())
                    ->attribute('tahun')
                    ->searchable(),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->deferFilters()
            ->deselectAllRecordsWhenFiltered()
            ->hiddenFilterIndicators()
            ->recordActions([
                Actions\ActionGroup::make([
                    Actions\ViewAction::make(),
                    Actions\EditAction::make(),
                    Actions\DeleteAction::make(),
                    Actions\ForceDeleteAction::make(),
                    Actions\RestoreAction::make(),
                    Actions\Action::make('Toggle Aktif')
                        ->icon('heroicon-s-arrow-path-rounded-square')
                        ->action(function ($record): void {
                            $record->status_aktif = match ($record->status_aktif) {
                                StatusAktif::AKTIF => StatusAktif::NONAKTIF,
                                StatusAktif::NONAKTIF => StatusAktif::AKTIF,
                            };

                            $record->save();
                        })
                        ->visible(fn() => auth()->user()?->hasRole(superadmin_admin_roles()))
                        ->after(function (): void {
                            Notification::make()
                                ->success()
                                ->title('Status Berhasil Diubah')
                                ->send();
                        })
                        ->close(),
                    Actions\Action::make('Ubah Status Verifikasi')
                        ->icon('heroicon-s-check-badge')
                        ->schema([
                            Section::make()->schema([
                                ToggleButtons::make('status_verifikasi')
                                    ->options(StatusVerifikasiEnum::class)
                                    ->enum(StatusVerifikasiEnum::class)
                                    ->label('Status Verifikasi')
                                    ->hiddenLabel()
                                    ->default(StatusVerifikasiEnum::UNVERIFIED)
                                    ->inline()
                                    ->required(),
                            ]),
                        ])
                        ->visible(fn() => auth()->user()?->hasRole(superadmin_admin_roles()))
                        ->authorize('verify_status_bantuan::rastra')
                        ->action(function ($record, array $data): void {
                            $record->status_verifikasi = $data['status_verifikasi'];

                            $record->save();
                        })
                        ->after(function (): void {
                            Notification::make()
                                ->success()
                                ->title('Status Berhasil Diubah')
                                ->send();
                        })
                        ->modalWidth(Width::FitContent)
                        ->close(),
                    Actions\Action::make('penggantiRastra')
                        ->label('Ganti KPM Baru')
                        ->icon('heroicon-s-user-plus')
                        ->schema([
                            Grid::make()->schema([
                                TextInput::make('nokk')
                                    ->label('No. KK Pengganti')
                                    ->required()
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (Page $livewire, TextInput $component): void {
                                        $livewire->validateOnly($component->getStatePath());
                                    })
                                    ->minLength(16)
                                    ->maxLength(16),
                                TextInput::make('nik')
                                    ->label('NIK Pengganti')
                                    ->required()
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (Page $livewire, TextInput $component): void {
                                        $livewire->validateOnly($component->getStatePath());
                                    })
                                    ->minLength(16)
                                    ->maxLength(16)
                                    ->unique(ignoreRecord: true),
                                TextInput::make('nama_lengkap')
                                    ->label('Nama Pengganti')
                                    ->required(),
                                TextInput::make('alamat')
                                    ->label('Alamat Pengganti')
                                    ->nullable(),
                                Select::make('kecamatan')
                                    ->required()
                                    ->searchable()
                                    ->reactive()
                                    ->options(get_kecamatan_options())
                                    ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                                Select::make('kelurahan')
                                    ->required()
                                    ->options(fn(callable $get) => get_kelurahan_options($get('kecamatan')))
                                    ->reactive()
                                    ->searchable(),
                                Select::make('penggantiRastra.alasan_dikeluarkan')
                                    ->searchable()
                                    ->options(AlasanEnum::class)
                                    ->enum(AlasanEnum::class)
                                    ->native(false)
                                    ->preload()
                                    ->lazy()
                                    ->required()
                                    ->default(AlasanEnum::PINDAH),
                                CuratorPicker::make('penggantiRastra.media_id')
                                    ->label('Upload Berita Acara Pengganti')
                                    ->relationship('beritaAcara', 'id')
                                    ->buttonLabel('Tambah File')
                                    ->required()
                                    ->rules(['required'])
                                    ->maxSize(2048),
                            ])->columns(2),
                        ])
                        ->modalWidth(Width::FourExtraLarge)
                        ->action(function ($record, array $data): void {
                            $keluargaDigantiId = $record->id;

                            $record->penggantiRastra()->updateOrCreate([
                                'bantuan_rastra_id' => $keluargaDigantiId,
                                'nik_pengganti' => $data['nik'],
                                'nokk_pengganti' => $data['nokk'],
                                'nama_pengganti' => $data['nama_lengkap'],
                                'alamat_pengganti' => $data['alamat'],
                                'alasan_dikeluarkan' => $data['penggantiRastra']['alasan_dikeluarkan'],
                                'media_id' => $data['penggantiRastra']['media_id'],
                            ], [
                                'bantuan_rastra_id' => $record->id,
                                'nik_pengganti' => $data['nik'],
                                'nama_pengganti' => $data['nama_lengkap'],
                            ]);

                            $record->create([
                                'nama_lengkap' => $data['nama_lengkap'],
                                'nik' => $data['nik'],
                                'nokk' => $data['nokk'],
                                'alamat' => $data['alamat'],
                                'kecamatan' => $data['kecamatan'],
                                'kelurahan' => $data['kelurahan'],
                                'status_rastra' => StatusRastra::BARU,
                                'status_dtks' => StatusDtksEnum::DTKS,
                                'status_verifikasi' => StatusVerifikasiEnum::VERIFIED,
                                'status_aktif' => StatusAktif::AKTIF,
                            ]);

                            $record->status_rastra = StatusRastra::PENGGANTI;
                            $record->status_aktif = StatusAktif::NONAKTIF;
                            $record->save();
                            $record->delete();

                        })
                        ->after(function (): void {
                            Notification::make()
                                ->success()
                                ->title('KPM Berhasil Diganti')
                                ->send();
                        })
                        ->close(),
                ]),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()
                        ->after(fn(Collection $records) => activity()
                            ->log('Hapus masal ' . $records->count() . ' data bantuan rastra')),
                    Actions\ForceDeleteBulkAction::make()
                        ->after(fn(Collection $records) => activity()
                            ->log('Hapus permanen masal ' . $records->count() . ' data bantuan rastra')),
                    Actions\RestoreBulkAction::make()
                        ->after(fn(Collection $records) => activity()
                            ->log('Pemulihan masal ' . $records->count() . ' data bantuan rastra')),
                    // ExportBulkAction::make()
                    //     ->label('Ekspor Ke Excel')
                    //     ->exports([
                    //         ExportBantuanRastra::make(),
                    //     ]),
                    Actions\BulkAction::make('toggle aktif')
                        ->label('Toggle Status Aktif')
                        ->icon('heroicon-o-cursor-arrow-ripple')
                        ->action(function (Collection $records): void {
                            $records->each(function ($record): void {
                                $record->status_aktif = match ($record->status_aktif) {
                                    StatusAktif::AKTIF => StatusAktif::NONAKTIF,
                                    StatusAktif::NONAKTIF => StatusAktif::AKTIF,
                                };

                                $record->save();
                            });
                        })
                        ->after(function (Collection $records): void {
                            activity()
                                ->log('Ubah status aktif masal ' . $records->count() . ' data bantuan rastra');

                            Notification::make()
                                ->success()
                                ->title('Status Berhasil Diubah')
                                ->send();
                        })
                        ->closeModalByClickingAway()
                        ->deselectRecordsAfterCompletion(),
                    Actions\BulkAction::make('ubah_status_verifikasi')
                        ->label('Ubah Status Verifikasi')
                        ->icon('heroicon-o-check-badge')
                        ->schema([
                            Section::make()->schema([
                                ToggleButtons::make('status_verifikasi')
                                    ->options(StatusVerifikasiEnum::class)
                                    ->enum(StatusVerifikasiEnum::class)
                                    ->label('Status Verifikasi')
                                    ->hiddenLabel()
                                    ->default(StatusVerifikasiEnum::UNVERIFIED)
                                    ->inline()
                                    ->required(),
                            ]),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $records->each(function ($record) use ($data): void {
                                $record->status_verifikasi = $data['status_verifikasi'];

                                $record->save();
                            });
                        })
                        ->after(function (Collection $records): void {
                            activity()
                                ->log('Ubah status verifikasi masal ' . $records->count() . ' data bantuan rastra');

                            Notification::make()
                                ->success()
                                ->title('Status Berhasil Diubah')
                                ->send();
                        })
                        ->modalWidth(Width::FitContent)
                        ->closeModalByClickingAway()
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Group::make()->schema([
                    Section::make('Data Keluarga')
                        ->schema(static::getKeluargaForm())->columns(2),
                    Section::make('Data Alamat')
                        ->schema(static::getAlamatForm())->columns(2),
                ])->columnSpan(['lg' => 2]),

                Group::make()->schema([
                    Section::make('Status')
                        ->schema(static::getStatusForm()),

                    Section::make('Verifikasi')
                        ->schema(static::getUploadForm()),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function getKeluargaForm(): array
    {
        return [
            Select::make('status_dtks')
                ->label('DTKS')
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
                ->rule(new NikValidationRule()),
            TextInput::make('nik')
                ->label('No. Induk Kependudukan (NIK)')
                ->required()
                ->unique(ignoreRecord: true)
                ->live(debounce: 500)
                ->afterStateUpdated(function (Page $livewire, TextInput $component): void {
                    $livewire->validateOnly($component->getStatePath());
                })
                ->rule(new NikValidationRule(checkAllPrograms: true, ignoreModel: \App\Models\BantuanRastra::class)),
            TextInput::make('nama_lengkap')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255),
        ];
    }

    public static function getAlamatForm(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    TextInput::make('alamat')
                        ->required()
                        ->columnSpanFull(),
                    Select::make('kecamatan')
                        ->required()
                        ->searchable()
                        ->live(onBlur: true)
                        ->native(false)
                        ->options(get_kecamatan_options())
                        ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                    Select::make('kelurahan')
                        ->required()
                        ->options(fn(callable $get) => get_kelurahan_options($get('kecamatan')))
                        ->live(onBlur: true)
                        ->native(false)
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
        ];
    }

    public static function getStatusForm(): array
    {
        return [
            Select::make('jenis_bantuan_id')
                ->required()
                ->searchable()
                ->disabled()
                ->hidden()
                ->relationship(
                    name: 'jenis_bantuan',
                    titleAttribute: 'alias',
                    modifyQueryUsing: fn(Builder $query) => $query->whereNotIn('id', [1, 2]),
                )
                ->default(5)
                ->dehydrated(),

            Select::make('status_verifikasi')
                ->label('Status Verifikasi')
                ->options(StatusVerifikasiEnum::class)
                ->default(StatusVerifikasiEnum::UNVERIFIED)
                ->preload()
                ->visible(fn() => auth()->user()?->hasRole(superadmin_admin_roles())),

            Select::make('status_rastra')
                ->label('Status Rastra')
                ->enum(StatusRastra::class)
                ->options(StatusRastra::class)
                ->default(StatusRastra::BARU)
                ->live()
                ->preload(),

            Select::make('penggantiRastra.keluarga_id')
                ->label('Keluarga Yang Diganti')
                ->required()
                ->options(BantuanRastra::query()
                    ->where('status_rastra', StatusRastra::BARU)
                    ->where('status_aktif', StatusAktif::AKTIF)
                    ->pluck('nama_lengkap', 'id'))
                ->searchable(['nama_lengkap', 'nik', 'nokk'])
                ->lazy()
                ->visible(fn(Get $get) => StatusRastra::PENGGANTI === $get('status_rastra'))
                ->preload(),

            Select::make('penggantiRastra.alasan_dikeluarkan')
                ->searchable()
                ->options(AlasanEnum::class)
                ->enum(AlasanEnum::class)
                ->native(false)
                ->preload()
                ->lazy()
                ->required()
                ->visible(fn(Get $get) => StatusRastra::PENGGANTI === $get('status_rastra'))
                ->default(AlasanEnum::PINDAH),

            CuratorPicker::make('penggantiRastra.media_id')
                ->label('Upload Berita Acara Pengganti')
                ->relationship('beritaAcara', 'id')
                ->buttonLabel('Tambah File')
                ->required()
                ->preserveFilenames()
                ->visible(fn(Get $get) => StatusRastra::PENGGANTI === $get('status_rastra'))
                ->maxSize(2048),

            TextInput::make('keterangan')
                ->label('Keterangan')->nullable(),

            ToggleButtons::make('status_aktif')
                ->label('Status Aktif')
                ->enum(StatusAktif::class)
                ->options(StatusAktif::class)
                ->default(StatusAktif::AKTIF)
                ->inline(),
        ];
    }

    public static function getUploadForm(): array
    {
        return [
            DateTimePicker::make('created_at')
                ->label('Tgl. Penyerahan')
                ->disabled()
                ->default(now())
                ->displayFormat('d/M/Y H:i:s')
                ->dehydrated(),
            FileUpload::make('foto_ktp_kk')
                ->label('Unggah Foto KTP / KK')
                ->image()
                ->imageEditor()
                ->reorderable()
                ->disk('public')
                ->openable()
                ->downloadable()
                ->imageEditor()
                ->imageEditorAspectRatioOptions([
                    null,
                    '16:9',
                    '4:3',
                    '1:1',
                ])
                ->unique(ignoreRecord: true)
                ->helperText('maks. 2MB')
                ->maxFiles(1)
                ->maxSize(2048)
                ->columnSpanFull()
                ->imagePreviewHeight('250')
                ->previewable(true),

            CuratorPicker::make('media_id')
                ->label('Upload Berita Acara')
                ->buttonLabel('Tambah File')
                ->relationship('beritaAcara', 'id')
                ->nullable()
                ->preserveFilenames()
                ->columnSpanFull(),
        ];
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Group::make([
                    Section::make('Informasi Keluarga')
                        ->icon('heroicon-o-user')
                        ->schema([
                            TextEntry::make('status_dtks')
                                ->label('Status DTKS')
                                ->weight(FontWeight::SemiBold)
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

                        ])->columns(2),
                    Section::make('Informasi Alamat')
                        ->icon('heroicon-o-map')
                        ->schema([
                            TextEntry::make('alamat')
                                ->label('Alamat')
                                ->icon('heroicon-o-map-pin')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary')
                                ->placeholder('Belum ada alamat')
                                ->columnSpanFull(),
                            TextEntry::make('kec.name')
                                ->label('Kecamatan')
                                ->placeholder('Belum ada kecamatan'),
                            TextEntry::make('kel.name')
                                ->label('Kelurahan')
                                ->placeholder('Belum ada kelurahan'),
                            TextEntry::make('dusun')
                                ->label('Dusun')
                                ->placeholder('Belum ada dusun'),
                            TextEntry::make('no_rt')
                                ->label('RT/RW')
                                ->placeholder('Belum ada RT/RW')
                                ->formatStateUsing(fn($record) => $record->no_rt . '/' . $record->no_rw),
                        ])->columns(2),
                ])->columnSpan(2),

                Group::make([
                    Section::make('Informasi Status Penerima')
                        ->icon('heroicon-o-lifebuoy')
                        ->schema([
                            TextEntry::make('status_verifikasi')
                                ->label('Status Verifikasi')
                                ->placeholder('Belum ada Status Verifikasi')
                                ->badge(),
                            TextEntry::make('status_rastra')
                                ->label('Status Rastra')
                                ->placeholder('Belum ada Status Rastra')
                                ->badge(),
                            TextEntry::make('status_aktif')
                                ->label('Status Aktif')
                                ->placeholder('Belum ada Status Aktif')
                                ->badge(),
                        ])
                        ->columns(3),
                    Section::make('Informasi Penyaluran Bantuan')
                        ->icon('heroicon-o-share')
                        ->schema([
                            TextEntry::make('penyaluran.status_penyaluran')
                                ->label('Status Penyaluran')
                                ->badge()
                                ->placeholder('Belum ada penyaluran'),
                            TextEntry::make('penyaluran.tgl_penyerahan')
                                ->dateTime('l, d M Y H:i:s')
                                ->label('Tgl. Penyerahan')
                                ->placeholder('Belum ada penyaluran'),
                        ])
                        ->columns(2),
                ])->columnSpan(1),

                Section::make('Informasi Verifikasi Foto KTP & Penyaluran')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        ImageEntry::make('foto_ktp_kk')
                            ->label('Foto KTP/KK')
                            ->placeholder('Belum ada Foto KTP / KK')
                            ->columnSpanFull()
                            ->extraImgAttributes([
                                'alt' => 'foto ktp kk',
                                'loading' => 'lazy',
                                'class' => 'mx-auto rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 max-w-full h-auto',
                                'style' => 'max-height: 500px; object-fit: contain;',
                            ]),
                        ImageEntry::make('penyaluran.foto_penyerahan')
                            ->label('Foto Penyaluran')
                            ->columnSpanFull()
                            ->placeholder('Belum ada Foto Penyaluran')
                            ->extraImgAttributes([
                                'alt' => 'foto penyaluran',
                                'loading' => 'lazy',
                                'class' => 'mx-auto rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 max-w-full h-auto',
                                'style' => 'max-height: 500px; object-fit: contain;',
                            ]),
                    ])->columnSpanFull()->columns(2),
            ])->columns(3);
    }

    public static function getWidgets(): array
    {
        return [
            BantuanRastraOverview::class,
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['kec', 'kel', 'kab']);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBantuanRastra::route('/'),
            'create' => Pages\CreateBantuanRastra::route('/create'),
            'view' => Pages\ViewBantuanRastra::route('/{record}'),
            'edit' => Pages\EditBantuanRastra::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['kec', 'kel', 'penggantiRastra'])
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
