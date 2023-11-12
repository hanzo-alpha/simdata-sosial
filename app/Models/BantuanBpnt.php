<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\StatusAktif;
use App\Traits\HasJenisBantuan;
use App\Traits\HasKeluarga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BantuanBpnt extends Model
{
    use HasKeluarga, HasJenisBantuan;

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
        'nominal',
        'status_bpnt',
    ];

    protected $casts = [
        'dtks_id' => 'string',
        'nominal' => MoneyCast::class,
        'status_bpnt' => StatusAktif::class
    ];

    public function jenis_bantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class);
    }
}
