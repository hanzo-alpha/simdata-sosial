<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\StatusPkhBpntEnum;
use App\Traits\HasJenisBantuan;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;

class BantuanPkh extends Model
{
    use HasJenisBantuan, HasWilayah;

    protected $table = 'bantuan_pkh';

    protected $guarded = [];

    protected $with = [
        'prov', 'kab', 'kec', 'kel', 'jenis_bantuan',
    ];

    protected $casts = [
        'dtks_id' => 'string',
        'nominal' => MoneyCast::class,
        'status_pkh' => StatusPkhBpntEnum::class,
    ];
}
