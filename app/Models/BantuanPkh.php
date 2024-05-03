<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\StatusPkhBpntEnum;
use App\Traits\HasJenisBantuan;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BantuanPkh extends Model
{
    use HasJenisBantuan;
    use HasWilayah;
    use SoftDeletes;

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
