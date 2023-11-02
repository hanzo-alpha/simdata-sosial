<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JenisPelayanan extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'jenis_pelayanan';
    protected $fillable = [
        'nama_ppks',
        'alias',
        'deskripsi',
    ];

    public function kriteria_pelayanan(): BelongsToMany
    {
        return $this->belongsToMany(KriteriaPelayanan::class, 'kriteria_jenis_pelayanan');
    }
}
