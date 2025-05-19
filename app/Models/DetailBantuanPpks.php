<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DetailBantuanPpks extends Model
{
    protected $fillable = [
        'bantuan_ppks_id',
        'nama_bantuan',
        'jumlah_bantuan',
        'jenis_anggaran',
        'tahun_anggaran',
        'bansos_diterima',
    ];

    public function bantuanPpks(): BelongsToMany
    {
        return $this->belongsToMany(BantuanPpks::class, 'bantuan_ppks_detail_bantuan_ppks');
    }

    public function bansosDiterima(): BelongsToMany
    {
        return $this->belongsToMany(BansosDiterima::class, 'bantuan_ppks_bansos_diterima');
    }

    protected function casts(): array
    {
        return [
            'bansos_diterima' => 'array',
        ];
    }
}
