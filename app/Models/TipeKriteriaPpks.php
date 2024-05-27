<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TipeKriteriaPpks extends Pivot
{
    protected $guarded = [];

    protected $table = 'tipe_kriteria_ppks';

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
