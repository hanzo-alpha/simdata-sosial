<?php

namespace App\Models;

use App\Enums\AlasanEnum;
use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusRastra;
use App\Enums\StatusVerifikasiEnum;
use App\Traits\HasKeluarga;
use App\Traits\HasTambahan;
use App\Traits\HasWilayah;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Wallo\FilamentSelectify\Components\ToggleButton;

class BantuanRastra extends Model
{
    use HasKeluarga, HasTambahan, HasWilayah;
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'bantuan_rastra';
    protected $guarded = [];

    protected $casts = [
        'dtks_id' => 'string',
        'bukti_foto' => 'array',
        'pengganti_rastra' => 'array',
        'status_kawin' => StatusKawinBpjsEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_rastra' => StatusRastra::class,
        'status_aktif' => StatusAktif::class
    ];

    public function family(): MorphOne
    {
        return $this->morphOne(Family::class, 'familyable');
    }

    public function familyable(): MorphTo
    {
        return $this->morphTo();
    }

    public function alamat(): MorphOne
    {
        return $this->morphOne(AlamatKeluarga::class, 'alamatable');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(AlamatKeluarga::class);
    }

    public function alamatKeluarga(): BelongsToMany
    {
        return $this->belongsToMany(Alamat::class, 'alamat_keluarga');
    }

    public function jenisBantuan(): MorphOne
    {
        return $this->morphOne(JenisBantuan::class, 'bantuanable');
    }

    public function keluarga(): HasMany
    {
        return $this->hasMany(Keluarga::class, 'jenis_bantuan_keluarga');
    }

    public function pengganti_rastra(): BelongsTo
    {
        return $this->belongsTo(PenggantiRastra::class);
    }

    public static function getKeluargaForm(): array
    {
        return [
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
                ->default(7)
                ->optionsLimit(15)
                ->preload(),
            Select::make('status_kawin')
                ->options(StatusKawinBpjsEnum::class)
                ->default(StatusKawinBpjsEnum::KAWIN)
                ->preload(),
        ];
    }

    public static function getStatusForm(): array
    {
        return [
            Select::make('jenis_bantuan_id')
                ->required()
                ->searchable()
                ->disabled()
                ->relationship(
                    name: 'jenis_bantuan',
                    titleAttribute: 'alias',
                    modifyQueryUsing: fn(Builder $query) => $query->whereNotIn('id', [1, 2])
                )
                ->default(5)
                ->dehydrated(),

            Select::make('status_verifikasi')
                ->label('Status Verifikasi')
                ->options(StatusVerifikasiEnum::class)
                ->default(StatusVerifikasiEnum::UNVERIFIED)
                ->preload()
                ->visible(fn() => auth()->user()?->hasRole(['super_admin', 'admin'])),

            Select::make('status_rastra')
                ->label('Status Rastra')
                ->enum(StatusRastra::class)
                ->options(StatusRastra::class)
                ->default(StatusRastra::BARU)
                ->live()
                ->preload(),

            Select::make('pengganti_rastra.keluarga_id')
                ->label('Keluarga Yang Diganti')
                ->required()
                ->options(self::query()->where('status_rastra', StatusRastra::BARU)->pluck('nama_lengkap', 'id'))
                ->searchable(['nama_lengkap', 'nik', 'nokk'])
//                ->getOptionLabelFromRecordUsing(function ($record) {
//                    return '<strong>' . $record->family->nama_lengkap . '</strong><br>' . $record->nik;
//                })->allowHtml()
                ->optionsLimit(15)
                ->lazy()
                ->visible(fn(Get $get) => $get('status_rastra') === StatusRastra::PENGGANTI)
                ->preload(),

            Select::make('pengganti_rastra.alasan_dikeluarkan')
                ->searchable()
                ->options(AlasanEnum::class)
                ->enum(AlasanEnum::class)
                ->native(false)
                ->preload()
                ->lazy()
                ->required()
                ->visible(fn(Get $get) => $get('status_rastra') === StatusRastra::PENGGANTI)
                ->default(AlasanEnum::PINDAH)
                ->optionsLimit(15),

            ToggleButton::make('status_aktif')
                ->label('Status Aktif')
                ->offColor('danger')
                ->onColor('primary')
                ->offLabel('Non Aktif')
                ->onLabel('Aktif')
                ->default(true),
        ];
    }

    public static function getUploadForm(): array
    {
        return [
            FileUpload::make('bukti_foto')
                ->label('Unggah Foto Rumah')
                ->getUploadedFileNameForStorageUsing(
                    fn(TemporaryUploadedFile $file
                    ): string => (string) str($file->getClientOriginalName())
                        ->prepend(date('d-m-Y-H-i-s') . '-'),
                )
                ->preserveFilenames()
                ->multiple()
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
        ];
    }
}
