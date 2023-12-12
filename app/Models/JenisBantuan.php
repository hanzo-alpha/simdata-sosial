<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JenisBantuan extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'jenis_bantuan';
    protected $fillable = [
        'nama_bantuan',
        'alias',
        'warna',
        'deskripsi',
    ];


    public function keluarga(): BelongsToMany
    {
        return $this->belongsToMany(Keluarga::class, 'jenis_bantuan_keluarga');
    }
}
