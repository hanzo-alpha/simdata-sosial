<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KriteriaPelayanan extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'kriteria_pelayanan';
    protected $fillable = [
        'jenis_pelayanan_id',
        'nama_kriteria',
    ];

    public function jenisPelayanan(): BelongsTo
    {
        return $this->belongsTo(JenisPelayanan::class);
    }
}
