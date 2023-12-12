<?php

namespace App\Models;

use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AlamatKeluarga extends Model
{
    use HasWilayah;

    protected $table = 'alamat_keluarga';
//    protected $fillable = [
//        'alamat',
//        'provinsi',
//        'kabupaten',
//        'kecamatan',
//        'kelurahan',
//        'no_rt',
//        'no_rw',
//        'dusun',
//        'kodepos',
//        'latitude',
//        'longitude',
//        'location',
//    ];

    public function alamatable(): MorphTo
    {
        return $this->morphTo();
    }
}
