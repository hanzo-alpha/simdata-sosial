<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BarangBeritaAcara extends Pivot
{
    protected $table = 'barang_berita_acara';

    protected $guarded = [];

    public function beritaAcara(): BelongsTo
    {
        return $this->belongsTo(BeritaAcara::class);
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
