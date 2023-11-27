<?php

namespace App\Models;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusKawinEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Traits\HasTambahan;
use App\Traits\HasWilayah;
use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

//class Keluarga extends ApprovableModel
class Keluarga extends Model
{
    use HasTambahan, HasWilayah, SoftDeletes;

    protected $table = 'keluarga';

    protected $fillable = [
        'name',
        'dtks_id',
        'nokk',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tgl_lahir',
        'notelp',
        'alamat_id',
        'nama_ibu_kandung',
        'jenis_bantuan_id',
        'pendidikan_terakhir_id',
        'hubungan_keluarga_id',
        'jenis_pekerjaan_id',
        'status_kawin',
        'jenis_kelamin',
        'status_keluarga',
        'status_verifikasi',
        'unggah_foto',
        'unggah_dokumen',
    ];

    protected $casts = [
        'tgl_lahir' => 'datetime',
        'status_kawin' => StatusKawinEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_keluarga' => StatusAktif::class,
        'status_verifikasi' => StatusVerifikasiEnum::class,
        'unggah_foto' => 'array',
        'unggah_dokumen' => 'array',
    ];

    protected $appends = [
        'location',
    ];

    public function anggota(): HasMany
    {
        return $this->hasMany(Anggota::class);
    }

    public function anggota_keluarga(): BelongsToMany
    {
        return $this->belongsToMany(Anggota::class, 'anggota_keluarga');
    }

    public function alamat(): MorphOne
    {
        return $this->morphOne(AddressKeluarga::class, 'addressable');
    }

    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'addressable');
    }

    public function address(): MorphOne
    {
        return $this->morphOne(AddressKeluarga::class, 'addressable');
    }

    public function provinsi(): HasOneThrough
    {
        return $this->hasOneThrough(Provinsi::class, AddressKeluarga::class);
    }

    public function jenis_bantuan_keluarga(): BelongsToMany
    {
        return $this->belongsToMany(JenisBantuan::class, 'jenis_bantuan_keluarga');
    }

    public function jenis_bantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class);
    }

    /**
     * ADD THE FOLLOWING METHODS TO YOUR Keluarga MODEL
     *
     * The 'latitude' and 'longitude' attributes should exist as fields in your table schema,
     * holding standard decimal latitude and longitude coordinates.
     *
     * The 'location' attribute should NOT exist in your table schema, rather it is a computed attribute,
     * which you will use as the field name for your Filament Google Maps form fields and table columns.
     *
     * You may of course strip all comments, if you don't feel verbose.
     */
    public function location(): Attribute
    {
        return Attribute::make(
        /**
         * @throws \JsonException
         */
            get: static fn($value, $attributes) => json_encode([
                'lat' => (float) $attributes['latitude'],
                'lng' => (float) $attributes['longitude'],
            ], JSON_THROW_ON_ERROR),
            set: static fn($value) => [
                'latitude' => $value['lat'],
                'longitude' => $value['lng'],
            ],
        );
    }

    /**
     * Returns the 'latitude' and 'longitude' attributes as the computed 'location' attribute,
     * as a standard Google Maps style Point array with 'lat' and 'lng' attributes.
     *
     * Used by the Filament Google Maps package.
     *
     * Requires the 'location' attribute be included in this model's $fillable array.
     *
     * @return array
     */
    public function getLocationAttribute(): array
    {
        return [
            'lat' => (float) $this->latitude,
            'lng' => (float) $this->longitude,
        ];
    }

    /**
     * Takes a Google style Point array of 'lat' and 'lng' values and assigns them to the
     * 'latitude' and 'longitude' attributes on this model.
     *
     * Used by the Filament Google Maps package.
     *
     * Requires the 'location' attribute be included in this model's $fillable array.
     *
     * @param ?array  $location
     * @return void
     */
    public function setLocationAttribute(?array $location): void
    {
        if (is_array($location)) {
            $this->attributes['latitude'] = $location['lat'];
            $this->attributes['longitude'] = $location['lng'];
            unset($this->attributes['location']);
        }
    }

    /**
     * Get the lat and lng attribute/field names used on this table
     *
     * Used by the Filament Google Maps package.
     *
     * @return string[]
     */
    public static function getLatLngAttributes(): array
    {
        return [
            'lat' => 'latitude',
            'lng' => 'longitude',
        ];
    }

    /**
     * Get the name of the computed location attribute
     *
     * Used by the Filament Google Maps package.
     *
     * @return string
     */
    public static function getComputedLocation(): string
    {
        return 'location';
    }
}
