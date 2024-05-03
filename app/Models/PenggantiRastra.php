<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AlasanEnum;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenggantiRastra extends Model
{
    protected $table = 'pengganti_rastra';

    protected $guarded = [];

    protected $casts = [
        'alasan_dikeluarkan' => AlasanEnum::class,
        'attachment' => 'array',
    ];

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(BantuanRastra::class);
    }

    public function beritaAcara(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }

    public function bantuan_rastra(): BelongsTo
    {
        return $this->belongsTo(BantuanRastra::class);
    }
}
