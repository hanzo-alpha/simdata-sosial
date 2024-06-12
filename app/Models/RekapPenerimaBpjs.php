<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;

class RekapPenerimaBpjs extends Model
{
    use HasWilayah;

    protected $fillable = [
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'bulan',
        'jumlah',
    ];
}
