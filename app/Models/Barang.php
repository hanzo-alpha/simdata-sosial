<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Barang extends Model
{
    protected $table = 'barang';

    protected $guarded = [];

    protected $with = ['kel'];

    public function beritaAcara(): BelongsToMany
    {
        return $this->belongsToMany(BeritaAcara::class, 'barang_berita_acara', 'barang_id', 'berita_acara_id');
    }

    public function kel(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'kode_kelurahan', 'code');
    }
}
