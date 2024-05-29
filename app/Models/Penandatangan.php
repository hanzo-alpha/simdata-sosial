<?php

namespace App\Models;

use App\Enums\JabatanEnum;
use App\Enums\StatusPenandatangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penandatangan extends Model
{
    protected $table = 'penandatangan';
    protected $with = ['kecamatan', 'kelurahan'];

    protected $guarded = [];

    protected $casts = [
        'status_penandatangan' => StatusPenandatangan::class,
        'jabatan' => JabatanEnum::class,
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kode_kecamatan', 'code');
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'kode_instansi', 'code');
    }
}
