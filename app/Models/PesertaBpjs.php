<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesertaBpjs extends Model
{
    use HasFactory;

    protected $table = 'peserta_bpjs';

    protected $guarded = [];

    protected $casts = [
        'bulan' => 'integer',
        'tahun' => 'integer',
    ];

    public function mutasi(): BelongsTo
    {
        return $this->belongsTo(MutasiBpjs::class);
    }
}
