<?php

namespace App\Models;

use App\Enums\StatusAktif;
use App\Traits\HasKeluarga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BantuanBpnt extends Model
{
    use HasKeluarga;

    public $timestamps = false;
    protected $table = 'bantuan_bpnt';
    protected $fillable = [
        'keluarga_id',
        'kode_wilayah',
        'tahap',
        'jenis_bantuan_id',
        'dtks_id',
        'bank',
        'dir',
        'gelombang',
        'status_bpnt',
    ];

    protected $casts = [
        'dtks_id' => 'string',
        'status_bpnt' => StatusAktif::class
    ];

    public function jenis_bantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class);
    }
}
