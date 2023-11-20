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

//    protected $appends = [
//        'location',
//    ];

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

    public function keluarga(): MorphToMany
    {
        return $this->morphedByMany(Keluarga::class, 'addressable');
    }

}
