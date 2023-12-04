<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Bantuan extends Model
{
    use HasFactory;

    protected $table = 'bantuan';

    public function bantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class);
    }

    public function bantuanable(): MorphTo
    {
        return $this->morphTo();
    }
}
