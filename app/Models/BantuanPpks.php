<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusKondisiRumahEnum;
use App\Enums\StatusRumahEnum;
use App\Traits\HasKeluarga;
use App\Traits\HasTambahan;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class BantuanPpks extends Model
{
    use HasKeluarga, HasTambahan, HasWilayah;
    use SoftDeletes;

    protected $table = 'bantuan_ppks';

    protected $guarded = [];

    protected $casts = [
        'kriteria_pelayanan' => 'array',
        'status_kawin' => StatusKawinBpjsEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_rumah_tinggal' => StatusRumahEnum::class,
        'status_bantuan' => StatusAktif::class,
        'status_kondisi_rumah' => StatusKondisiRumahEnum::class,
        'penghasilan_rata_rata' => MoneyCast::class,
        'bukti_foto' => 'array',
        'status_aktif' => StatusAktif::class
    ];

    public function jenis_pelayanan(): BelongsTo
    {
        return $this->belongsTo(JenisPelayanan::class);
    }

    public function kriteriaPelayanan(): BelongsToMany
    {
        return $this->belongsToMany(KriteriaPelayanan::class, 'kriteria_jenis_pelayanan');
    }

    public function alamat(): MorphOne
    {
        return $this->morphOne(AlamatKeluarga::class, 'alamatable');
    }


}
