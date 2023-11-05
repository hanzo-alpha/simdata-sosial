<?php

namespace App\Traits;

use App\Models\Keluarga;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasKeluarga
{
    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class);
    }
}
