<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Kabupaten extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'code';

    protected $table = 'kabupaten';

    protected $fillable = [
        'provinsi_code',
        'name',
    ];

    public function prov(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_code', 'code');
    }

    public function kec(): HasMany
    {
        return $this->hasMany(Kecamatan::class, 'kabupaten_code', 'code');
    }

    public function kel(): HasManyThrough
    {
        return $this->hasManyThrough(Kelurahan::class, Kecamatan::class, 'kabupaten_code', 'kecamatan_code');
    }

//    public function kep(): HasMany
//    {
//        return $this->hasMany(Pulau::class, 'kabupaten_code', 'code');
//    }
}
