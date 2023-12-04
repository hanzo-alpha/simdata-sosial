<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JenisPsks extends Model
{
    public $timestamps = false;
    protected $table = 'jenis_psks';
    protected $fillable = [
        'nama_psks',
        'alias',
        'deskripsi',
    ];

    public function kriteria_pelayanan(): BelongsToMany
    {
        return $this->belongsToMany(KriteriaPelayanan::class, 'kriteria_jenis_pelayanan');
    }
}
