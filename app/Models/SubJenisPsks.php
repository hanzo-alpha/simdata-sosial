<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubJenisPsks extends Model
{
    public $timestamps = false;

    protected $table = 'sub_jenis_psks';

    public function jenis_psks(): BelongsTo
    {
        return $this->belongsTo(JenisPsks::class);
    }
}
