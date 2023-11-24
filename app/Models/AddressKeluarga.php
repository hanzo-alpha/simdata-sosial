<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AddressKeluarga extends Model
{
    protected $table = 'addresses_keluarga';
    protected $fillable = [
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'no_rt',
        'no_rw',
        'dusun',
        'kodepos',
        'latitude',
        'longitude',
    ];

    protected $appends = [
        'location',
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

//    public function location(): Attribute
//    {
//        return Attribute::make(
//        /**
//         * @throws \JsonException
//         */
//            get: static fn($value, $attributes) => json_encode([
//                'lat' => (float) $attributes['latitude'],
//                'lng' => (float) $attributes['longitude'],
//            ], JSON_THROW_ON_ERROR),
//            set: static fn($value) => [
//                'latitude' => $value['lat'],
//                'longitude' => $value['lng'],
//            ],
//        );
//    }


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
