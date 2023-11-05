<?php

namespace App\Models;

use App\Enums\StatusAktif;
use App\Traits\HasKeluarga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BantuanPkh extends Model
{
    use HasKeluarga;

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
        'status_pkh',
    ];

    protected $casts = [
        'dtks_id' => 'string',
        'status_pkh' => StatusAktif::class
    ];

    public function jenis_bantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class);
    }
}
