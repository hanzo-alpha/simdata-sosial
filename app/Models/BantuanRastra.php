<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AlasanEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusDtksEnum;
use App\Enums\StatusRastra;
use App\Enums\StatusVerifikasiEnum;
use App\Traits\HasTambahan;
use App\Traits\HasWilayah;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Models\Media;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class BantuanRastra extends Model
{
    use HasTambahan;
    use HasWilayah;
    use SoftDeletes;

    protected $table = 'bantuan_rastra';

    protected $guarded = [];
    protected $with = [
        'kec','kel','penggantiRastra',
    ];

    protected $casts = [
        'dtks_id' => 'string',
        'foto_ktp_kk' => 'array',
        'pengganti_rastra' => 'array',
        'status_dtks' => StatusDtksEnum::class,
        'status_rastra' => StatusRastra::class,
        'status_aktif' => StatusAktif::class,
        'status_verifikasi' => StatusVerifikasiEnum::class,
    ];

    public static function getLatLngAttributes(): array
    {
        return [
            'lat' => 'latitude',
            'lng' => 'longitude',
        ];
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
                            return Kelurahan::query()
                                ->when(
                                    auth()->user()->instansi_id,
                                    fn(Builder $query) => $query->where(
                                        'code',
                                        auth()->user()->instansi_id,
                                    ),
                                )
                                ->where('kecamatan_code', $get('kecamatan'))
                                ?->pluck('name', 'code');
                        })
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
                ->options(self::query()
                    ->where('status_rastra', StatusRastra::BARU)
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
                ->imageEditorAspectRatios([
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

    public function beritaAcara(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }

    public function penyaluran(): HasOne
    {
        return $this->hasOne(PenyaluranBantuanRastra::class);
    }

    public function attachments(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }

    public function penggantiRastra(): HasOne
    {
        return $this->hasOne(PenggantiRastra::class);
    }

    protected static function booted(): void
    {
        //        static::deleted(static function (BantuanRastra $bantuanRastra): void {
        //            foreach ($bantuanRastra->foto_ktp_kk as $image) {
        //                Storage::delete("public/{$image}");
        //            }
        //        });
        //
        //        static::updating(static function (BantuanRastra $bantuanRastra): void {
        //            $imagesToDelete = array_diff($bantuanRastra->getOriginal('foto_ktp_kk'), $bantuanRastra->foto_ktp_kk);
        //
        //            foreach ($imagesToDelete as $image) {
        //                Storage::delete("public/{$image}");
        //            }
        //        });
    }
}
