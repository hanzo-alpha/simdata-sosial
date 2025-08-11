<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetailBantuanPpks extends Model
{
    protected $fillable = [
        'barang_id',
        'nama_bantuan',
        'jumlah_bantuan',
        'jenis_anggaran',
        'tahun_anggaran',
        'bansos_diterima',
    ];

    protected $with = ['barang', 'bansosDiterima'];

    public function bantuanPpks(): BelongsToMany
    {
        return $this->belongsToMany(BantuanPpks::class, 'bantuan_ppks_detail_bantuan_ppks');
    }

    public function bansosDiterima(): BelongsToMany
    {
        return $this->belongsToMany(BansosDiterima::class, 'bantuan_ppks_bansos_diterima')
            ->withTimestamps();
    }

    public function bansosDiterimas(): HasMany
    {
        return $this->hasMany(BansosDiterima::class);
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    protected function casts(): array
    {
        return [
            'bansos_diterima' => 'array',
        ];
    }
}
