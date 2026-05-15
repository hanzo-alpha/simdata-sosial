<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\JabatanEnum;
use App\Enums\StatusPenandatangan;
use App\Traits\HasKelurahanScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penandatangan extends Model
{
    use HasKelurahanScope;
    protected $table = 'penandatangan';
    protected $with = ['kecamatan', 'kelurahan'];

    protected $guarded = [];

    public function getKelurahanColumn(): string
    {
        return 'kode_instansi';
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kode_kecamatan', 'code');
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'kode_instansi', 'code');
    }

    protected function casts(): array
    {
        return [
            'status_penandatangan' => StatusPenandatangan::class,
            'jabatan' => JabatanEnum::class,
        ];
    }
}
