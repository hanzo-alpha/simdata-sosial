<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipePpks extends Model
{
    protected $guarded = [];

    protected $table = 'tipe_ppks';

    public function kriteria_ppks(): HasMany
    {
        return $this->hasMany(KriteriaPpks::class);
    }
}
