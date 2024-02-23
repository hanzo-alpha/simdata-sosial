<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipePpks extends Model
{
    protected $guarded = [];

    protected $table = 'tipe_ppks';

    protected $with = ['kriteria_ppks'];

    public function kriteria_ppks(): BelongsToMany
    {
        return $this->belongsToMany(KriteriaPpks::class, 'tipe_kriteria_ppks');
    }

    public function kriteriaPpks(): HasMany
    {
        return $this->hasMany(KriteriaPpks::class);
    }
}
