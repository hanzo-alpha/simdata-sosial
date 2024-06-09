<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BantuanBpnt extends Model
{
    use HasWilayah;
    use SoftDeletes;

    protected $table = 'bantuan_bpnt';

    protected $guarded = [];

    protected $with = [
        'prov', 'kab', 'kec', 'kel',
    ];
}
