<?php

namespace App\Models;

use App\Traits\HasWilayah;
use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Address extends Model
{
    use HasWilayah;

    public $timestamps = false;
    protected $table = 'addresses';

    protected $fillable = [
        'keluarga_id',
        'alamat',
        'no_rt',
        'no_rw',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'dusun',
        'kodepos',
        'location',
        'latitude',
        'longitude',
        'full_address',
    ];

    private function getAlamatLengkap(array $attributes): string
    {
        $sep = ', ';

        return $attributes['alamat'] . $sep . $attributes['provinsi'] . $sep . $attributes['kabupaten'] .
            $sep . $attributes['kecamatan'] . $sep . $attributes['kelurahan'] . $sep . $attributes['dusun'] .
            $sep . $attributes['no_rt'] . $sep . $attributes['no_rw'] . $sep . $attributes['kodepos'];
    }

    public function fullAddress(): Attribute
    {
        return Attribute::make(
            get: static fn($value) => $value,
            set: static fn($value, $attributes) => $this->getAlamatLengkap($attributes)
        );
    }

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
                'lat' => $value['lat'],
                'lng' => $value['lng'],
            ],
        );
    }

    public function keluargas(): MorphToMany
    {
        return $this->morphedByMany(Keluarga::class, 'addressable');
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
