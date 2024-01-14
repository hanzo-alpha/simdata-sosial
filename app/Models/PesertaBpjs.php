<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class PesertaBpjs extends Model
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
