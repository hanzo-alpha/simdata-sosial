<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\StatusAktif;
use App\Enums\StatusKondisiRumahEnum;
use App\Enums\StatusRumahEnum;
use App\Traits\HasKeluarga;
use App\Traits\HasTambahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class BantuanPpks extends Model
{
    use HasKeluarga, HasTambahan, SoftDeletes;

    protected $table = 'bantuan_ppks';

    protected $guarded = [];

    protected $casts = [
        'kriteria_pelayanan' => 'array',
        'status_rumah_tinggal' => StatusRumahEnum::class,
        'status_bantuan' => StatusAktif::class,
        'status_kondisi_rumah' => StatusKondisiRumahEnum::class,
        'penghasilan_rata_rata' => MoneyCast::class
    ];

    public function jenis_pelayanan(): BelongsTo
    {
        return $this->belongsTo(JenisPelayanan::class);
    }

//    public function kriteria_pelayanan(): BelongsToMany
//    {
//        return $this->belongsToMany(KriteriaPelayanan::class, 'kriteria_jenis_pelayanan');
//    }

    public function alamat(): MorphOne
    {
        return $this->morphOne(AlamatKeluarga::class, 'alamatable');
    }


}
