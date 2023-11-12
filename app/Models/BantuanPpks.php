<?php

namespace App\Models;

use App\Enums\StatusAktif;
use App\Enums\StatusKondisiRumahEnum;
use App\Enums\StatusRumahEnum;
use App\Traits\HasKeluarga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BantuanPpks extends Model
{
    use HasKeluarga;

    protected $fillable = [
        'keluarga_id',
        'jenis_ppks',
        'jenis_pelayanan_id',
        'jenis_bantuan_id',
        'penghasilan_rata_rata',
        'status_rumah_tinggal',
        'status_kondisi_rumah',
        'anggaran_id',
        'status_bantuan',
    ];

    protected $casts = [
        'jenis_ppks' => 'array',
        'status_rumah_tinggal' => StatusRumahEnum::class,
        'status_bantuan' => StatusAktif::class,
        'status_kondisi_rumah' => StatusKondisiRumahEnum::class
    ];

    public function jenis_pelayanan(): BelongsTo
    {
        return $this->belongsTo(JenisPelayanan::class);
    }

    public function jenis_bantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class);
    }


}
