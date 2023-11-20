<?php

namespace App\Models;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusKawinEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Traits\HasTambahan;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keluarga extends Model
{
    use HasTambahan, HasWilayah, SoftDeletes;

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
        'status_verifikasi',
        'unggah_foto',
        'unggah_dokumen',
    ];

    protected $casts = [
        'tgl_lahir' => 'datetime',
        'status_kawin' => StatusKawinEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_keluarga' => StatusAktif::class,
        'status_verifikasi' => StatusVerifikasiEnum::class,
        'unggah_foto' => 'array',
        'unggah_dokumen' => 'array',
    ];

    public function anggota(): HasMany
    {
        return $this->hasMany(Anggota::class);
    }

    public function anggota_keluarga(): BelongsToMany
    {
        return $this->belongsToMany(Anggota::class, 'anggota_keluarga');
    }

    public function alamat(): BelongsTo
    {
        return $this->belongsTo(Alamat::class);
    }

    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'addressable');
    }

    public function address(): MorphOne
    {
        return $this->morphOne(AddressKeluarga::class, 'addressable');
    }

    public function jenis_bantuan_keluarga(): BelongsToMany
    {
        return $this->belongsToMany(JenisBantuan::class, 'jenis_bantuan_keluarga');
    }

    public function jenis_bantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class);
    }
}
