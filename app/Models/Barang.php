<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    protected $table = 'barang';

    protected $guarded = [];

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Penandatangan::class);
    }
}
