<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BansosDiterima extends Model
{
    protected $table = 'bansos_diterima';
    protected $guarded = [];

    public function bantuan_ppks(): BelongsTo
    {
        return $this->belongsTo(BantuanPpks::class);
    }
}
