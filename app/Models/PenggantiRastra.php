<?php

namespace App\Models;

use App\Enums\AlasanEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenggantiRastra extends Model
{
//    use HasKeluarga;

    protected $table = 'pengganti_rastra';
    protected $guarded = [];
//    protected $fillable = [
//        'keluarga_id',
//        'nokk_pengganti',
//        'nik_pengganti',
//        'nama_pengganti',
//        'alamat_pengganti',
//        'alasan_dikeluarkan',
//    ];

    protected $casts = [
        'alasan_dikeluarkan' => AlasanEnum::class
    ];

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(BantuanRastra::class);
    }

    public function bantuan_rastra(): BelongsTo
    {
        return $this->belongsTo(BantuanRastra::class);
    }
}
