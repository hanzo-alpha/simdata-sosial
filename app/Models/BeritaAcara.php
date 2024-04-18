<?php

namespace App\Models;

use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BeritaAcara extends Model
{
    use HasWilayah;

    protected $table = 'berita_acara';

    protected $casts = [
        'tgl_ba' => 'date',
    ];

    protected $with = [
        'penandatangan', 'itemBantuan', 'kel', 'kec'
    ];

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Penandatangan::class);
    }

    public function bantuan_rastra(): BelongsTo
    {
        return $this->belongsTo(BantuanRastra::class);
    }

    public function itemBantuan(): BelongsToMany
    {
        return $this->belongsToMany(Barang::class, 'barang_berita_acara', 'berita_acara_id', 'barang_id')
            ->withTimestamps();
    }
}
