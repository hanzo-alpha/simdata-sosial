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
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Models\Media;
use Awcodes\Curator\PathGenerators\DatePathGenerator;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Wallo\FilamentSelectify\Components\ToggleButton;

class BantuanRastra extends Model
{
    use HasKeluarga, HasTambahan, HasWilayah;
    use SoftDeletes;

    protected $table = 'bantuan_rastra';
    protected $guarded = [];

    protected $casts = [
        'dtks_id' => 'string',
        'bukti_foto' => 'array',
        'foto_pegang_ktp' => 'array',
        'attachments' => 'array',
        'pengganti_rastra' => 'array',
        'tgl_lahir' => 'date',
        'status_kawin' => StatusKawinBpjsEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_rastra' => StatusRastra::class,
        'status_aktif' => StatusAktif::class
    ];

    public static function getLatLngAttributes(): array
    {
        return Alamat::getLatLngAttributes();
//        return [
//            'lat' => 'latitude',
//            'lng' => 'longitude',
//        ];
    }

    public function family(): MorphOne
    {
        return $this->morphOne(Family::class, 'familyable');
    }

    public function alamat(): MorphOne
    {
        return $this->morphOne(Alamat::class, 'alamatable');
    }

    public function mediaFoto(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
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
                ->disabled()
                ->dehydrated()
                ->default(\Str::orderedUuid()->toString()),
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

//            Select::make('jenis_pekerjaan_id')
//                ->relationship('jenis_pekerjaan', 'nama_pekerjaan')
//                ->searchable()
//                ->optionsLimit(15)
//                ->default(6)
//                ->preload(),
//            Select::make('pendidikan_terakhir_id')
//                ->relationship('pendidikan_terakhir', 'nama_pendidikan')
//                ->searchable()
//                ->default(5)
//                ->optionsLimit(15)
//                ->preload(),
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

    public static function getAlamatForm(): array
    {
        return [
            Grid::make()
                ->schema([
                    Geocomplete::make('alamat')
                        ->countries(['id'])
                        ->updateLatLng()
                        ->geocodeOnLoad()
                        ->columnSpanFull()
                        ->reverseGeocode([
                            'country' => '%C',
                            'city' => '%L',
                            'city_district' => '%D',
                            'zip' => '%z',
                            'state' => '%A1',
                            'street' => '%S %n',
                        ]),
                    Grid::make(2)->schema([
                        TextInput::make('latitude')
                            ->disabled()
                            ->dehydrated()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $set('location', [
                                    'lat' => floatVal($state),
                                    'lng' => floatVal($get('longitude')),
                                ]);
                            })
                            ->lazy(), // important to use lazy, to avoid updates as you type
                        TextInput::make('longitude')
                            ->disabled()
                            ->dehydrated()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $set('location', [
                                    'lat' => (float) $get('latitude'),
                                    'lng' => floatVal($state),
                                ]);
                            })
                            ->lazy(),
                    ]),
                ]),
            Grid::make(2)
                ->schema([
//                    TextInput::make('alamat')
//                        ->required()
//                        ->columnSpanFull(),
                    Select::make('kecamatan')
                        ->required()
                        ->searchable()
                        ->reactive()
                        ->options(function () {
                            $kab = Kecamatan::query()->where('kabupaten_code', config('custom.default.kodekab'));
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
                            return Kelurahan::query()->where('kecamatan_code', $get('kecamatan'))?->pluck('name',
                                'code');
                        })
                        ->reactive()
                        ->searchable(),
                ]),

            Grid::make(4)
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
                    TextInput::make('kodepos')
                        ->label('Kodepos')
                        ->default('90861')
                        ->required(),
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
                ->options(self::query()
                    ->where('status_rastra', StatusRastra::BARU)
                    ->pluck('nama_lengkap', 'id'))
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
            DateTimePicker::make('created_at')
                ->label('Tgl. Penyerahan')
                ->disabled()
                ->default(now())
                ->displayFormat('d/M/Y H:i:s')
                ->dehydrated(),
            FileUpload::make('bukti_foto')
                ->label('Unggah Foto Penyerahan')
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

            FileUpload::make('foto_pegang_ktp')
                ->label('Unggah Foto Pegang KTP/KK')
                ->getUploadedFileNameForStorageUsing(
                    fn(TemporaryUploadedFile $file
                    ): string => (string) str($file->getClientOriginalName())
                        ->prepend(date('d-m-Y-H-i-s') . '-'),
                )
                ->preserveFilenames()
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
