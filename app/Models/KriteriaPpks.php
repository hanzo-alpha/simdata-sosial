<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KriteriaPpks extends Model
{
    protected $table = 'kriteria_ppks';

    protected $guarded = [];

    public function tipe_ppks(): BelongsTo
    {
        return $this->belongsTo(TipePpks::class);
    }
}
