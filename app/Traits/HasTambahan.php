<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\HubunganKeluarga;
use App\Models\JenisBantuan;
use App\Models\JenisPekerjaan;
use App\Models\PendidikanTerakhir;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasTambahan
{
    public function jenis_bantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class)->orderBy('id');
    }

    public function pendidikan_terakhir(): BelongsTo
    {
        return $this->belongsTo(PendidikanTerakhir::class)->orderBy('id');
    }

    public function hubungan_keluarga(): BelongsTo
    {
        return $this->belongsTo(HubunganKeluarga::class)->orderBy('id');
    }

    public function jenis_pekerjaan(): BelongsTo
    {
        return $this->belongsTo(JenisPekerjaan::class)->orderBy('id');
    }
}
