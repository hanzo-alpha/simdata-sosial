<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;

class BantuanBpnt extends Model
{
    use HasWilayah;

    protected $table = 'bantuan_bpnt';

    protected $guarded = [];

    protected $with = [
        'prov', 'kab', 'kec', 'kel',
    ];
}
