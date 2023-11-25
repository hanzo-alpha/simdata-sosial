<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Traits\HasJenisBantuan;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BantuanPkh extends Model
{
    use HasJenisBantuan, HasWilayah;

    protected $table = 'bantuan_pkh';
    protected $fillable = [
        'dtks_id',
        'nokk',
        'nik_ktp',
        'nama_penerima',
        'kode_wilayah',
        'tahap',
        'bansos',
        'jenis_bantuan',
        'bank',
        'nominal',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'alamat',
        'no_rt',
        'no_rw',
        'dusun',
        'dir',
        'gelombang',
        'status_pkh',
    ];

    protected $casts = [
        'dtks_id' => 'string',
        'nominal' => MoneyCast::class,
        'status_pkh' => 'string'
    ];

    public function jenis_bantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class);
    }
}
