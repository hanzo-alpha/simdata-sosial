<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusBpjsEnum;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusUsulanEnum;
use App\Filament\Resources\BantuanBpjsResource\Pages;
use App\Filament\Resources\BantuanBpjsResource\Widgets\BantuanBpjsOverview;
use App\Models\BantuanBpjs;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Str;
use Wallo\FilamentSelectify\Components\ToggleButton;

class BantuanBpjsResource extends Resource
{
    protected static ?string $model = BantuanBpjs::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $slug = 'program-bpjs';
    protected static ?string $label = 'Program BPJS';
    protected static ?string $pluralLabel = 'Program BPJS';
    protected static ?string $navigationLabel = 'Program BPJS';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?string $recordTitleAttribute = 'nama_lengkap';

    public static function table(Table $table): Table
    {
        return $table
            ->poll()
            ->deferLoading()
            ->defaultSort('created_at', 'desc')
            ->columns([
                BadgeableColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->suffixBadges([
                        Badge::make('umur')
                            ->label(fn($record) => hitung_umur($record->tgl_lahir) . ' Tahun')
                            ->color('gray'),
                    ])
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_tmt')
                    ->label('N I K')
                    ->toggleable()
                    ->sortable()
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nokk_tmt')
                    ->label('No. KK')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->copyable()
                    ->searchable(),
                BadgeableColumn::make('tempat_lahir')
                    ->label('Tempat Tanggal Lahir')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->suffix(fn($record) => ', ' . $record->tgl_lahir->format(setting('app.format_tgl')))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->label('Tgl. Lahir')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->date(setting('app.format_tgl', 'd/m/Y'))
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
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kec.name')
                    ->label('Kecamatan')
                    ->sortable()
                    ->formatStateUsing(fn($state) => Str::upper($state))
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kel.name')
                    ->label('Kelurahan')
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn($state) => Str::upper($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('dusun')
                    ->label('Dusun')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('nort')
                    ->label('RT')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('norw')
                    ->label('RW')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('bulan')
                    ->label('Periode')
                    ->formatStateUsing(fn($record) => bulan_to_string($record->bulan) . ' ' . $record->tahun)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('tahun')
                    ->label('Tahun')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status_usulan')
                    ->label('Status Usulan')
                    ->sortable()
                    ->toggleable()
                    ->badge(),
                Tables\Columns\TextColumn::make('status_bpjs')
                    ->label('Status BPJS')
                    ->sortable()
                    ->toggleable()
                    ->badge(),
                Tables\Columns\TextColumn::make('status_aktif')
                    ->label('Status Aktif')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->badge(),
                Tables\Columns\ImageColumn::make('foto_ktp')
                    ->label('Foto KTP')
                    ->circular()
                    ->stacked()
                    ->wrap()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('keterangan')
                    ->searchable(),
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
                SelectFilter::make('status_usulan')
                    ->label('Status Usulan')
                    ->options(StatusUsulanEnum::class)
                    ->preload(),
                SelectFilter::make('status_bpjs')
                    ->label('Status BPJS')
                    ->options(StatusBpjsEnum::class),
                SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(list_tahun())
                    ->searchable(),
                SelectFilter::make('bulan')
                    ->label('Bulan')
                    ->options(list_bulan())
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
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->icon('heroicon-o-arrow-down-tray')
                        ->label('Download Terpilih'),
                    Tables\Actions\BulkAction::make('ubah status usulan')
                        ->label('Ubah Status Usulan')
                        ->icon('heroicon-o-cursor-arrow-ripple')
                        ->requiresConfirmation()
                        ->form([
                            Select::make('status_usulan')
                                ->options(StatusUsulanEnum::class)
                                ->preload()
                                ->lazy(),
                        ])
                        ->action(fn(Collection $record, $data) => $record->each->update($data))
                        ->after(function (): void {
                            Notification::make()
                                ->success()
                                ->title('Berhasil merubah status usulan peserta')
                                ->send();
                        })
                        ->closeModalByClickingAway()
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            BantuanBpjsOverview::class,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Section::make('Data Penerima Manfaat')
                        ->schema([
                            Forms\Components\TextInput::make('nokk_tmt')
                                ->label('No. Kartu Keluarga (KK)')
                                ->required()
                                ->minLength(16)
                                ->maxLength(16),
                            Forms\Components\TextInput::make('nik_tmt')
                                ->label('NIK')
                                ->required()
                                ->unique(
                                    table: 'peserta_bpjs',
                                    column: 'nik',
                                    //                                    modifyRuleUsing: fn(Unique $rule, $record) => dd($rule->where('nik')),
                                )
                                ->minLength(16)
                                ->maxLength(16),
                            Forms\Components\TextInput::make('nama_lengkap')
                                ->label('Nama Lengkap')
                                ->required()
                                ->dehydrateStateUsing(fn($state) => Str::upper($state))
                                ->afterStateUpdated(fn($state) => Str::upper($state))
                                ->maxLength(255),
                            Forms\Components\TextInput::make('tempat_lahir')
                                ->label('Tempat Lahir')
                                ->dehydrateStateUsing(fn($state) => Str::upper($state))
                                ->afterStateUpdated(fn($state) => Str::upper($state))
                                ->maxLength(100),
                            Forms\Components\DatePicker::make('tgl_lahir')
                                ->label('Tgl. Lahir')
                                ->displayFormat('d/M/Y'),
                            Forms\Components\Select::make('jenis_kelamin')
                                ->label('Jenis Kelamin')
                                ->options(JenisKelaminEnum::class)
                                ->default(JenisKelaminEnum::LAKI),
                        ])->columns(2),
                    Forms\Components\Section::make('Data Alamat Penerima')
                        ->schema([
                            TextInput::make('alamat')
                                ->required()
                                ->dehydrateStateUsing(fn($state) => Str::upper($state))
                                ->afterStateUpdated(fn($state) => Str::upper($state))
                                ->columnSpanFull(),
                            Select::make('kecamatan')
                                ->required()
                                ->searchable()
                                ->reactive()
                                ->options(function () {
                                    $kab = Kecamatan::query()->where(
                                        'kabupaten_code',
                                        setting('app.kodekab', config('custom.default.kodekab')),
                                    );
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

                            Grid::make(3)
                                ->schema([
                                    TextInput::make('dusun')
                                        ->label('Dusun')
                                        ->hidden()
                                        ->default('Dusun 1')
                                        ->dehydrated()
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
                        ])->columns(2),
                ])->columnSpan(2),

                Forms\Components\Group::make([
                    Forms\Components\Section::make('Data Status Penerima')
                        ->schema([
                            Grid::make()->schema([
                                Select::make('bulan')
                                    ->label('Periode Bulan')
                                    ->options(list_bulan(true))
                                    ->default(now()->month),
                                Select::make('tahun')
                                    ->label('Periode Tahun')
                                    ->options(list_tahun())
                                    ->default(now()->year),
                            ])->columns(2),
                            Select::make('status_nikah')
                                ->options(StatusKawinBpjsEnum::class)
                                ->default(StatusKawinBpjsEnum::BELUM_KAWIN)
                                ->preload(),
                            Forms\Components\Select::make('status_bpjs')
                                ->label('Status BPJS')
                                ->enum(StatusBpjsEnum::class)
                                ->options(StatusBpjsEnum::class)
                                ->default(StatusBpjsEnum::BARU)
                                ->live()
                                ->preload(),

                            Forms\Components\Select::make('status_usulan')
                                ->label('Status Pengembalian Usulan Dari BPJS')
                                ->enum(StatusUsulanEnum::class)
                                ->options(StatusUsulanEnum::class)
                                ->default(StatusUsulanEnum::ONPROGRESS)
                                ->lazy()
                                ->visible(auth()->user()?->hasRole(['admin', 'super_admin']))
                                ->preload(),

                            Forms\Components\Textarea::make('keterangan')
                                ->visible(auth()->user()?->hasRole(['admin', 'super_admin']))
                                ->visible(auth()->user()?->hasRole(['admin', 'super_admin']))
                                ->autosize(),

                            FileUpload::make('foto_ktp')
                                ->label('Unggah Foto KTP / KK')
//                                ->getUploadedFileNameForStorageUsing(
//                                    fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
//                                        ->prepend(date('dmYHis') . '-'),
//                                )
//                                ->preserveFilenames()
                                ->multiple()
                                ->reorderable()
                                ->appendFiles()
                                ->openable()
                                ->downloadable()
                                ->uploadingMessage('Sedang mengupload...')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->helperText('maks. 2MB')
                                ->maxFiles(3)
                                ->maxSize(2048)
                                ->loadingIndicatorPosition('left')
                                ->columnSpanFull()
                                ->imagePreviewHeight('170')
                                ->previewable(true)
                                ->image()
                                ->imageEditor()
                                ->imageEditorAspectRatios([
                                    null,
                                    '16:9',
                                    '4:3',
                                    '1:1',
                                ]),

                            ToggleButton::make('status_aktif')
                                ->label('Status Aktif')
                                ->offColor(StatusAktif::NONAKTIF->getColor())
                                ->onColor(StatusAktif::AKTIF->getColor())
                                ->offLabel(StatusAktif::NONAKTIF->getLabel())
                                ->onLabel(StatusAktif::AKTIF->getLabel())
                                ->visible(auth()->user()?->hasRole(['admin', 'super_admin']))
                                ->default(0),
                        ]),
                ])->columns(1),
            ])->columns(3);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Group::make([
                    Section::make('Informasi Keluarga')
                        ->icon('heroicon-o-user')
                        ->schema([
                            TextEntry::make('nomor_kartu')
                                ->label('No. Kartu')
                                ->copyable()
                                ->weight(FontWeight::SemiBold)
                                ->icon('heroicon-o-identification')
                                ->color('primary'),
                            TextEntry::make('nokk_tmt')
                                ->label('No. Kartu Keluarga (KK)')
                                ->copyable()
                                ->weight(FontWeight::SemiBold)
                                ->icon('heroicon-o-identification')
                                ->color('primary'),
                            TextEntry::make('nik_tmt')
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
                                ->label('Tempat Tanggal Lahir')
                                ->weight(FontWeight::SemiBold)
                                ->icon('heroicon-o-home')
                                ->formatStateUsing(function ($record) {
                                    $tglLahir = Carbon::parse($record->tgl_lahir);
                                    $umur = hitung_umur($tglLahir);

                                    $tgl = $tglLahir->format('d F Y');
                                    return $record->tempat_lahir . ', ' . $tgl . ' (' . $umur . ' tahun)';
                                })
                                ->color('primary'),
                            TextEntry::make('alamat')
                                ->label('Alamat')
                                ->icon('heroicon-o-map-pin')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                        ])->columns(2),
                    Section::make('Informasi Alamat')
                        ->icon('heroicon-o-map-pin')
                        ->schema([
                            TextEntry::make('alamat')
                                ->label('Alamat Lengkap')
                                ->columnSpanFull()
                                ->icon('heroicon-o-map-pin')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary')
                                ->formatStateUsing(function ($record) {
                                    $alamat = Str::title($record->alamat);
                                    $kec = Str::title($record->kec->name);
                                    $kel = Str::title($record->kel->name);
                                    $dusun = ! empty($record->dusun)
                                        ? ', ' . Str::title($record->dusun)
                                        : '';
                                    $rtrw = 'RT. ' . $record->nort . ' /RW. ' . $record->norw;
                                    return $alamat
                                        . $dusun
                                        . ', '
                                        . $rtrw
                                        . ', Kec. '
                                        . $kec
                                        . ', Kel. '
                                        . $kel
                                        . ', '
                                        . $record->kodepos;
                                }),
                            TextEntry::make('kec.name')
                                ->label('Kecamatan')
                                ->icon('heroicon-o-map')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('kel.name')
                                ->label('Kelurahan')
                                ->icon('heroicon-o-map')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('dusun')
                                ->label('Dusun')
                                ->icon('heroicon-o-map')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('nort')
                                ->label('RT/RW')
                                ->formatStateUsing(fn($record) => 'RT. ' . $record->nort . '/RW. ' . $record->norw)
                                ->icon('heroicon-o-map')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                        ])->columns(2),
                ])->columnSpan(2),

                Group::make([
                    Section::make('Informasi Bantuan Dan Status Penerima')
                        ->icon('heroicon-o-lifebuoy')
                        ->schema([
                            TextEntry::make('bulan')
                                ->label('PERIODE')
                                ->formatStateUsing(fn($record) => bulan_to_string($record->bulan) . ' ' . $record->tahun)
                                ->weight(FontWeight::SemiBold)
                                ->color('primary'),
                            TextEntry::make('jenis_kelamin')
                                ->label('Jenis Kelamin')
                                ->weight(FontWeight::SemiBold)
                                ->badge(),
                            TextEntry::make('status_kawin')
                                ->label('Status Kawin')
                                ->weight(FontWeight::SemiBold)
                                ->badge(),
                            TextEntry::make('status_verifikasi')
                                ->label('Verifikasi Berkas/Foto')
                                ->weight(FontWeight::SemiBold)
                                ->badge(),
                            TextEntry::make('status_bpjs')
                                ->label('Status BPJS')
                                ->weight(FontWeight::SemiBold)
                                ->badge(),
                            TextEntry::make('status_aktif')
                                ->label('Status Aktif')
                                ->weight(FontWeight::SemiBold)
                                ->badge(),
                            TextEntry::make('status_dtks')
                                ->label('STATUS DTKS')
                                ->weight(FontWeight::SemiBold)
                                ->badge(),
                            TextEntry::make('keterangan')
                                ->weight(FontWeight::SemiBold)
                                ->color('info'),
                        ])
                        ->columns(2),

                    Section::make('Informasi Foto')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            ImageEntry::make('foto_ktp')
                                ->hiddenLabel()
                                ->columnSpanFull()
                                ->alignCenter()
                                ->limit(2)
                                ->height(300)
                                ->extraImgAttributes([
                                    'alt' => 'foto ktp',
                                    'loading' => 'lazy',
                                ]),
                        ])->columns(1),
                ])->columns(1),

            ])->columns(3);
    }

    //    public static function getGlobalSearchEloquentQuery(): Builder
    //    {
    //        return parent::getGlobalSearchEloquentQuery();
    //    }

    //    public static function getRelations(): array
    //    {
    //        return [
    //            //
    //        ];
    //    }

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
