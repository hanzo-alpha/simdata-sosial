<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\StatusPkhBpntEnum;
use App\Traits\HasJenisBantuan;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BantuanBpnt extends Model
{
    use HasJenisBantuan, HasWilayah;

    protected $table = 'bantuan_bpnt';
    protected $guarded = [];
//    protected $fillable = [
//        'dtks_id',
//        'nokk',
//        'nik_ktp',
//        'nama_penerima',
//        'kode_wilayah',
//        'tahap',
//        'bansos',
//        'jenis_bantuan',
//        'bank',
//        'nominal',
//        'provinsi',
//        'kabupaten',
//        'kecamatan',
//        'kelurahan',
//        'alamat',
//        'no_rt',
//        'no_rw',
//        'dusun',
//        'dir',
//        'gelombang',
//        'status_pkhbpnt',
//    ];

    protected $casts = [
        'dtks_id' => 'string',
        'nominal' => MoneyCast::class,
        'status_bpnt' => StatusPkhBpntEnum::class,
    ];

    public function jenis_bantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class);
    }
}
