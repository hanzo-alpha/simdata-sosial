<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\StatusPkhBpntEnum;
use App\Traits\HasJenisBantuan;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class BantuanBpnt extends Model
{
    use HasJenisBantuan;
    use HasWilayah;

    protected $table = 'bantuan_bpnt';

    protected $guarded = [];

    protected $casts = [
        'dtks_id' => 'string',
        'nominal' => MoneyCast::class,
        'status_bpnt' => StatusPkhBpntEnum::class,
    ];

    public function jenis_bantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class);
    }
}
