<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\JenisBantuan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasJenisBantuan
{
    public function jenis_bantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class);
    }
}
