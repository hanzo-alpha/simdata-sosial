<?php

namespace App\Models;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusKawinEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Traits\HasTambahan;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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
        'status_kawin' => StatusKawinEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_keluarga' => StatusAktif::class,
        'status_verifikasi' => StatusVerifikasiEnum::class,
        'unggah_foto' => 'array',
        'unggah_dokumen' => 'array',
        'alamat_penerima' => 'string'
    ];

    public function alamat(): MorphOne
    {
        return $this->morphOne(AlamatKeluarga::class, 'alamatable');
    }

    public function familyable(): MorphTo
    {
        return $this->morphTo();
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function bantuan(): MorphMany
    {
        return $this->morphMany(Bantuan::class, 'bantuanable');
    }
}
