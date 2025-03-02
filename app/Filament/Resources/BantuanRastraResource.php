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
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class BantuanRastraResource extends Resource
{
    protected static ?string $model = BantuanRastra::class;

    protected static ?string $navigationIcon = 'heroicon-o-share';
    protected static ?string $slug = 'program-rastra';
    protected static ?string $label = 'Program Rastra';
    protected static ?string $pluralLabel = 'Program Rastra';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 4;
    protected static ?string $recordTitleAttribute = 'nama_lengkap';

    public static function table(Table $table): Table
    {
        return $table
            ->poll()
            ->deferLoading()
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada bantuan RASTRA')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
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
                    ->description(function ($record): void {
                        'Kec. ' . $record->kec->name . ' Kel. ' . $record->kel->name;
                    })
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
                    ->form([
                        Forms\Components\Select::make('kecamatan')
                            ->options(function () {
                                return Kecamatan::query()
                                    ->where('kabupaten_code', setting('app.kodekab'))
                                    ->pluck('name', 'code');
                            })
                            ->live()
                            ->searchable()
                            ->native(false),
                        Forms\Components\Select::make('kelurahan')
                            ->options(function (Forms\Get $get) {
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
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\Action::make('Toggle Aktif')
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
                    Tables\Actions\Action::make('Ubah Status Verifikasi')
                        ->icon('heroicon-s-check-badge')
                        ->form([
                            Section::make()->schema([
                                Forms\Components\ToggleButtons::make('status_verifikasi')
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
                        ->modalWidth(MaxWidth::FitContent)
                        ->close(),
                    Tables\Actions\Action::make('penggantiRastra')
                        ->label('Ganti KPM Baru')
                        ->icon('heroicon-s-user-plus')
                        ->form([
                            Forms\Components\Grid::make()->schema([
                                Forms\Components\TextInput::make('nokk')
                                    ->label('No. KK Pengganti')
                                    ->required()
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (Page $livewire, TextInput $component): void {
                                        $livewire->validateOnly($component->getStatePath());
                                    })
                                    ->minLength(16)
                                    ->maxLength(16),
                                Forms\Components\TextInput::make('nik')
                                    ->label('NIK Pengganti')
                                    ->required()
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (Page $livewire, TextInput $component): void {
                                        $livewire->validateOnly($component->getStatePath());
                                    })
                                    ->minLength(16)
                                    ->maxLength(16)
                                    ->unique(ignoreRecord: true),
                                Forms\Components\TextInput::make('nama_lengkap')
                                    ->label('Nama Pengganti')
                                    ->required(),
                                Forms\Components\TextInput::make('alamat')
                                    ->label('Alamat Pengganti')
                                    ->nullable(),
                                Select::make('kecamatan')
                                    ->required()
                                    ->searchable()
                                    ->reactive()
                                    ->options(function () {
                                        $kab = Kecamatan::query()
                                            ->where('kabupaten_code', setting(
                                                'app.kodekab',
                                                config('custom.default.kodekab'),
                                            ));
                                        if ( ! $kab) {
                                            return Kecamatan::where('kabupaten_code', setting(
                                                'app.kodekab',
                                                config('custom.default.kodekab'),
                                            ))
                                                ->pluck('name', 'code');
                                        }

                                        return $kab->pluck('name', 'code');
                                    })
                                    ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                                Select::make('kelurahan')
                                    ->required()
                                    ->options(function (callable $get) {
                                        return Kelurahan::query()->where('kecamatan_code', $get('kecamatan'))?->pluck(
                                            'name',
                                            'code',
                                        );
                                    })
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
                        ->modalWidth(MaxWidth::FourExtraLarge)
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    ExportBulkAction::make()
                        ->label('Ekspor Ke Excel')
                        ->exports([
                            ExportBantuanRastra::make(),
                        ]),
                    Tables\Actions\BulkAction::make('toggle aktif')
                        ->label('Toggle Status Aktif')
                        ->icon('heroicon-o-cursor-arrow-ripple')
                        ->action(function ($records): void {
                            $records->each(function ($records): void {
                                $records->status_aktif = match ($records->status_aktif) {
                                    StatusAktif::AKTIF => StatusAktif::NONAKTIF,
                                    StatusAktif::NONAKTIF => StatusAktif::AKTIF,
                                };

                                $records->save();
                            });
                        })
                        ->after(function (): void {
                            Notification::make()
                                ->success()
                                ->title('Status Berhasil Diubah')
                                ->send();
                        })
                        ->closeModalByClickingAway()
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('ubah_status_verifikasi')
                        ->label('Ubah Status Verifikasi')
                        ->icon('heroicon-o-check-badge')
                        ->form([
                            Section::make()->schema([
                                Forms\Components\ToggleButtons::make('status_verifikasi')
                                    ->options(StatusVerifikasiEnum::class)
                                    ->enum(StatusVerifikasiEnum::class)
                                    ->label('Status Verifikasi')
                                    ->hiddenLabel()
                                    ->default(StatusVerifikasiEnum::UNVERIFIED)
                                    ->inline()
                                    ->required(),
                            ]),
                        ])
                        ->action(function ($records, array $data): void {
                            $records->each(function ($records) use ($data): void {
                                $records->status_verifikasi = $data['status_verifikasi'];

                                $records->save();
                            });
                        })
                        ->after(function (): void {
                            Notification::make()
                                ->success()
                                ->title('Status Berhasil Diubah')
                                ->send();
                        })
                        ->modalWidth(MaxWidth::FitContent)
                        ->closeModalByClickingAway()
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Data Keluarga')
                        ->schema(BantuanRastra::getKeluargaForm())->columns(2),
                    Section::make('Data Alamat')
                        ->schema(BantuanRastra::getAlamatForm())->columns(2),
                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Section::make('Status')
                        ->schema(BantuanRastra::getStatusForm()),

                    Forms\Components\Section::make('Verifikasi')
                        ->schema(BantuanRastra::getUploadForm()),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Group::make([
                    \Filament\Infolists\Components\Section::make('Informasi Keluarga')
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
                    \Filament\Infolists\Components\Section::make('Informasi Alamat')
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

                \Filament\Infolists\Components\Group::make([
                    \Filament\Infolists\Components\Section::make('Informasi Status Penerima')
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
                    \Filament\Infolists\Components\Section::make('Informasi Penyaluran Bantuan')
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
                    \Filament\Infolists\Components\Section::make('Informasi Verifikasi Foto KTP & Penyaluran')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            ImageEntry::make('foto_ktp_kk')
                                ->label('Foto KTP/KK')
                                ->placeholder('Belum ada Foto KTP / KK')
                                ->columnSpanFull()
                                ->alignCenter()
                                ->width(280)
                                ->height(400)
                                ->extraImgAttributes([
                                    'alt' => 'foto ktp kk',
                                    'loading' => 'lazy',
                                ]),
                            ImageEntry::make('penyaluran.foto_penyerahan')
                                ->label('Foto Penyaluran')
                                ->columnSpanFull()
                                ->placeholder('Belum ada Foto Penyaluran')
                                ->alignCenter()
                                ->width(280)
                                ->height(400)
                                ->extraImgAttributes([
                                    'alt' => 'foto penyaluran',
                                    'loading' => 'lazy',
                                ]),
                        ])->columns(1),
                ])->columns(1),

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
