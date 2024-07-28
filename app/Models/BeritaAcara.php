<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BeritaAcara extends Model
{
    use HasWilayah;

    protected $table = 'berita_acara';

    protected $casts = [
        'tgl_ba' => 'date',
        'upload_ba' => 'array',
        'bantuan_rastra_ids' => 'array',
    ];

    protected $with = [
        'penandatangan', 'itemBantuan', 'kel', 'kec',
    ];

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Penandatangan::class);
    }

    public function bantuanRastra(): HasMany
    {
        return $this->hasMany(BantuanRastra::class);
    }

    public function itemBantuan(): BelongsToMany
    {
        return $this->belongsToMany(Barang::class, 'barang_berita_acara')
            ->withTimestamps();
    }
}
