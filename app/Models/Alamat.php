<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Alamat extends Model
{

    public $timestamps = false;
    protected $table = 'alamat';

    protected $appends = [
        'location',
    ];

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
    ];

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

    public function keluarga(): BelongsToMany
    {
        return $this->belongsToMany(Keluarga::class, 'alamat_keluarga');
    }
}
