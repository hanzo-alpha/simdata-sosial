<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\StatusAktif;
use App\Traits\HasJenisBantuan;
use App\Traits\HasKeluarga;
use Illuminate\Database\Eloquent\Model;

class BantuanPkh extends Model
{
    use HasKeluarga, HasJenisBantuan;

    public $timestamps = false;
    protected $table = 'bantuan_pkh';
    protected $fillable = [
        'keluarga_id',
        'kode_wilayah',
        'tahap',
        'jenis_bantuan_id',
        'dtks_id',
        'bank',
        'dir',
        'gelombang',
        'nominal',
        'status_pkh',
    ];

    protected $casts = [
        'dtks_id' => 'string',
        'nominal' => MoneyCast::class,
        'status_pkh' => StatusAktif::class
    ];
}
