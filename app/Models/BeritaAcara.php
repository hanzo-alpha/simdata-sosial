<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasKelurahanScope;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BeritaAcara extends Model
{
    use HasKelurahanScope;
    use HasWilayah;
    use SoftDeletes;
    use \Spatie\Activitylog\Models\Concerns\LogsActivity;

    protected $table = 'berita_acara';

    protected $with = [
        'penandatangan', 'itemBantuan', 'kel', 'kec',
    ];

    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

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

    protected function casts(): array
    {
        return [
            'tgl_ba' => 'date',
            'upload_ba' => 'array',
            'bantuan_rastra_ids' => 'array',
        ];
    }
}
