<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\JenisAnggaranEnum;
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
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class BantuanPpks extends Model
{
    use HasKeluarga, HasTambahan, HasWilayah;
    use SoftDeletes;

    protected $table = 'bantuan_ppks';

    protected $guarded = [];

    protected $casts = [
        'status_kawin' => StatusKawinBpjsEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_rumah_tinggal' => StatusRumahEnum::class,
        'status_bantuan' => StatusAktif::class,
        'status_kondisi_rumah' => StatusKondisiRumahEnum::class,
        'penghasilan_rata_rata' => MoneyCast::class,
        'bukti_foto' => 'array',
        'sub_jenis_disabilitas' => 'array',
        'status_aktif' => StatusAktif::class,
        'bantuan_yang_pernah_diterima' => 'array',
        'jenis_anggaran' => JenisAnggaranEnum::class,
        'jumlah_bantuan' => 'integer',
        'tahun_anggaran' => 'integer'
    ];

    public function jenis_disabilitas(): BelongsTo
    {
        return $this->belongsTo(JenisDisabilitas::class);
    }

    public function subjenisdisabilitas(): BelongsTo
    {
        return $this->belongsTo(SubJenisDisabilitas::class);
    }

    public function alamat(): MorphOne
    {
        return $this->morphOne(Alamat::class, 'alamatable');
    }


}
