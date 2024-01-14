<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AlasanEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class PenggantiRastra extends Model
{
    protected $table = 'pengganti_rastra';

    protected $guarded = [];

    protected $casts = [
        'alasan_dikeluarkan' => AlasanEnum::class,
    ];

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(BantuanRastra::class);
    }

    public function bantuan_rastra(): BelongsTo
    {
        return $this->belongsTo(BantuanRastra::class);
    }
}
