<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

final class Kecamatan extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'code';

    protected $table = 'kecamatan';

    protected $fillable = [
        'kabupaten_code',
        'name',
    ];

    public function prov(): HasOneThrough
    {
        return $this->hasOneThrough(
            Provinsi::class,
            Kabupaten::class,
            'code',
            'code',
            'kabupaten_code',
            'provinsi_code',
        );
    }

    public function kab(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_code', 'code');
    }

    public function kel(): HasMany
    {
        return $this->hasMany(Kelurahan::class, 'kecamatan_code', 'code');
    }

    public function kep(): HasOneThrough
    {
        return $this->hasOneThrough(
            Provinsi::class,
            Kabupaten::class,
            'code',
            'code',
            'kabupaten_code',
            'provinsi_code',
        );
    }
}
