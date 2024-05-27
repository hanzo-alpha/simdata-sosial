<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BantuanPpksKriteriaPpks extends Pivot
{
    protected $guarded = [];

    protected $table = 'bantuan_ppks_kriteria_ppks';

    public function kriteriaPpks(): BelongsTo
    {
        return $this->belongsTo(KriteriaPpks::class);
    }

    public function tipePpks(): BelongsTo
    {
        return $this->belongsTo(TipePpks::class);
    }

    public function bantuanPpks(): BelongsTo
    {
        return $this->belongsTo(BantuanPpks::class);
    }
}
