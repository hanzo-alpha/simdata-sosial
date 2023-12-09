<?php

namespace App\Models;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusBpjsEnum;
use App\Enums\StatusKawinBpjsEnum;
use App\Traits\HasKeluarga;
use App\Traits\HasTambahan;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class BantuanBpjs extends Model
{
    use HasKeluarga, HasTambahan, HasWilayah;
    use SoftDeletes;

    public $timestamps = false;

    protected $table = 'bantuan_bpjs';

    protected $guarded = [];

    protected $casts = [
        'dkts_id' => 'string',
//        'bukti_foto' => 'array',
        'mutasi' => 'array',
        'status_kawin' => StatusKawinBpjsEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_bpjs' => StatusBpjsEnum::class,
        'status_aktif' => StatusAktif::class
    ];

    public function family(): MorphOne
    {
        return $this->morphOne(Family::class, 'familyable');
    }

    public function alamat(): MorphOne
    {
        return $this->morphOne(AlamatKeluarga::class, 'alamatable');
    }

    public function bantuan_bpjs(): BelongsToMany
    {
        return $this->belongsToMany(Bantuan::class, 'jenis_bantuan');
    }
}
