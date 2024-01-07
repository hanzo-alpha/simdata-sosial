<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasWilayah
{
    public function prov(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi', 'code');
    }

    public function kab(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten', 'code');
    }

    public function kec(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan', 'code');
    }

    public function kel(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan', 'code');
    }
}
