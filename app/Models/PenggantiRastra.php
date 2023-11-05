<?php

namespace App\Models;

use App\Enums\AlasanEnum;
use App\Traits\HasKeluarga;
use Illuminate\Database\Eloquent\Model;

class PenggantiRastra extends Model
{
    use HasKeluarga;

    public $timestamps = false;
    protected $table = 'pengganti_rastra';
    protected $fillable = [
        'keluarga_id',
        'nokk_pengganti',
        'nik_pengganti',
        'nama_pengganti',
        'alamat_pengganti',
        'alasan_dikeluarkan',
    ];

    protected $casts = [
        'alasan_dikeluarkan' => AlasanEnum::class
    ];
}
