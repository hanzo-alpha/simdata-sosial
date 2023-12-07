<?php

namespace App\Models;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusKawinEnum;
use App\Enums\StatusRastra;
use App\Traits\HasKeluarga;
use App\Traits\HasTambahan;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class BantuanRastra extends Model
{
    use HasKeluarga, HasTambahan, HasWilayah;
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'bantuan_rastra';
    protected $guarded = [];

    protected $casts = [
        'dtks_id' => 'string',
        'bukti_foto' => 'array',
        'status_kawin' => StatusKawinEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_rastra' => StatusRastra::class,
        'status_aktif' => StatusAktif::class
    ];

    public function alamat(): MorphOne
    {
        return $this->morphOne(AlamatKeluarga::class, 'alamatable');
    }
}
