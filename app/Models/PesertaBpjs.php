<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class PesertaBpjs extends Model
{
    use HasFactory;

    protected $table = 'peserta_bpjs';

    protected $guarded = [];

    protected $casts = [
        'bulan' => 'integer',
        'tahun' => 'integer',
        'is_mutasi' => 'datetime',
    ];

    public function mutasi(): BelongsTo
    {
        return $this->belongsTo(MutasiBpjs::class);
    }

    public function mutasiBpjs(): HasMany
    {
        return $this->hasMany(MutasiBpjs::class);
    }
}
