<?php

namespace App\Models;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusKawinEnum;
use App\Traits\HasTambahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Keluarga extends Model
{
    use HasTambahan;

    public $timestamps = false;
    protected $table = 'keluarga';
    protected $fillable = [
        'nokk',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tgl_lahir',
        'notelp',
        'alamat_id',
        'nama_ibu_kandung',
        'jenis_bantuan_id',
        'pendidikan_terakhir_id',
        'hubungan_keluarga_id',
        'jenis_pekerjaan_id',
        'status_kawin',
        'jenis_kelamin',
        'status_keluarga',
    ];

    protected $casts = [
        'tgl_lahir' => 'datetime',
        'status_kawin' => StatusKawinEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_keluarga' => StatusAktif::class
    ];

    public function alamat(): BelongsTo
    {
        return $this->belongsTo(Alamat::class);
    }

    public function jenis_bantuan(): BelongsToMany
    {
        return $this->belongsToMany(JenisBantuan::class);
    }
}
