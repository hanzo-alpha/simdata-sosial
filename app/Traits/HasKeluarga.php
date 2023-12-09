<?php

namespace App\Traits;

use App\Models\Family;
use App\Models\Keluarga;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasKeluarga
{
    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }
}
