<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\JenisAnggaranEnum;
use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusDtksEnum;
use App\Enums\StatusKawinUmumEnum;
use App\Enums\StatusKondisiRumahEnum;
use App\Enums\StatusRumahEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Traits\HasTambahan;
use App\Traits\HasWilayah;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class BantuanPpks extends Model
{
    use HasRelationships;
    use HasTambahan;
    use HasWilayah;
    use SoftDeletes;

    protected $table = 'bantuan_ppks';

    protected $guarded = [];

    protected $with = [
        'detailBantuanPpks',
        'tipe_ppks',
        'bansosDiterima',
        'kab', 'kec', 'kel',
    ];

    protected $casts = [
        'status_kawin' => StatusKawinUmumEnum::class,
        'status_dtks' => StatusDtksEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_rumah_tinggal' => StatusRumahEnum::class,
        'status_kondisi_rumah' => StatusKondisiRumahEnum::class,
        'status_verifikasi' => StatusVerifikasiEnum::class,
        'penghasilan_rata_rata' => MoneyCast::class,
        'bukti_foto' => 'array',
        'foto_ktp_kk' => 'array',
        'foto_penyerahan' => 'array',
        'status_aktif' => StatusAktif::class,
        'jenis_anggaran' => JenisAnggaranEnum::class,
//        'jumlah_bantuan' => 'integer',
//        'nama_bantuan' => 'string',
        'keterangan' => 'string',
        'tgl_lahir' => 'date',
        'tgl_ba' => 'datetime',
//        'tahun_anggaran' => 'integer',
        'kriteria_ppks' => 'json',
        'kriteria_tags_ppks' => 'json',
        'kategori_tags_ppks' => 'json',
        'bansos_diterima_ids' => 'array',
    ];

    public function tipe_ppks(): BelongsTo
    {
        return $this->belongsTo(TipePpks::class);
    }

    public function detailBantuanPpks(): BelongsToMany
    {
        return $this->belongsToMany(DetailBantuanPpks::class, 'bantuan_ppks_detail_bantuan_ppks');
    }

    public function bansosDiterima(): BelongsToMany
    {
        return $this->belongsToMany(BansosDiterima::class, 'bantuan_ppks_bansos_diterima')->withTimestamps();
    }

    public function kriteria(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations($this->tipe_ppks(), (new TipePpks())->kriteria_ppks());
    }

    public function subKategori(): BelongsToMany
    {
        return $this->belongsToMany(
            KriteriaPpks::class,
            'tipe_kriteria_ppks',
        )->withTimestamps();
    }

    public function kriteriaPpks(): BelongsToMany
    {
        return $this->belongsToMany(
            KriteriaPpks::class,
            'bantuan_ppks_kriteria_ppks',
        )->withTimestamps();
    }

    public function beritaAcara(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Penandatangan::class);
    }

    public function penyaluran(): HasOne
    {
        return $this->hasOne(PenyaluranBantuanPpks::class);
    }

//    public function barang(): BelongsTo
//    {
//        return $this->belongsTo(Barang::class);
//    }
}
