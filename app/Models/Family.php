<?php

namespace App\Models;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Traits\HasTambahan;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{
    use HasTambahan, HasWilayah, SoftDeletes;

    protected $table = 'family';

    protected $guarded = [];

    protected $casts = [
        'tgl_lahir' => 'datetime',
        'status_kawin' => StatusKawinBpjsEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_family' => StatusAktif::class,
        'status_verifikasi' => StatusVerifikasiEnum::class,
//        'unggah_foto' => 'array',
//        'foto' => 'array',
    ];

    public function alamat(): MorphOne
    {
        return $this->morphOne(AlamatKeluarga::class, 'alamatable');
    }
//
    public function bantuanRastra(): MorphTo
    {
        return $this->morphTo();
    }

    public function bantuan(): MorphOne
    {
        return $this->morphOne(Bantuan::class, 'bantuanable');
    }
}
