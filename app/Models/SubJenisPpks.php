<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubJenisPpks extends Model
{
    public $timestamps = false;
    protected $table = 'sub_jenis_ppks';

    public function jenis_ppks(): BelongsTo
    {
        return $this->belongsTo(JenisPpks::class);
    }
}
