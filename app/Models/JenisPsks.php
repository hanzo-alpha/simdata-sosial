<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPsks extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nama_psks',
        'alias',
        'deskripsi',
    ];

    public function sub_jenis_psks(): HasMany
    {
        return $this->hasMany(SubJenisPsks::class);
    }
}
