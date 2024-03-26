<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class KriteriaPpks extends Model
{
    protected $table = 'kriteria_ppks';

    protected $guarded = [];

    public function tipePpks(): BelongsTo
    {
        return $this->belongsTo(TipePpks::class);
    }

    public function tipe_ppks(): BelongsToMany
    {
        return $this->belongsToMany(TipePpks::class, 'tipe_kriteria_ppks');
    }

    public function bantuan_ppks(): BelongsToMany
    {
        return $this->belongsToMany(BantuanPpks::class, 'tipe_kriteria_ppks');
    }
}
