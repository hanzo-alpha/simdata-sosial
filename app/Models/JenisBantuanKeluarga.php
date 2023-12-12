<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JenisBantuanKeluarga extends Pivot
{
    public $timestamps = false;
    protected $table = 'jenis_bantuan_keluarga';

    protected $fillable = [
        'jenis_bantuan_id',
        'keluarga_id',
    ];
}
