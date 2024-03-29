<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\JenisAnggaranEnum;
use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusDtksEnum;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusKondisiRumahEnum;
use App\Enums\StatusRumahEnum;
use App\Traits\HasTambahan;
use App\Traits\HasWilayah;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        'tipe_ppks'
    ];

    protected $casts = [
        'status_kawin' => StatusKawinBpjsEnum::class,
        'status_dtks' => StatusDtksEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_rumah_tinggal' => StatusRumahEnum::class,
        'status_kondisi_rumah' => StatusKondisiRumahEnum::class,
        'penghasilan_rata_rata' => MoneyCast::class,
        'bukti_foto' => 'array',
        'foto_ktp_kk' => 'array',
        'foto_penyerahan' => 'array',
        'kriteria_ppks' => 'array',
        'status_aktif' => StatusAktif::class,
        'jenis_anggaran' => JenisAnggaranEnum::class,
        'jumlah_bantuan' => 'integer',
        'nama_bantuan' => 'string',
        'keterangan' => 'string',
        'tahun_anggaran' => 'integer',
    ];

    public function tipe_ppks(): BelongsTo
    {
        return $this->belongsTo(TipePpks::class);
    }

    public function bansos_diterima(): BelongsToMany
    {
        return $this->belongsToMany(BansosDiterima::class, 'bantuan_ppks_bansos_diterima')->withTimestamps();
    }

    public function kriteria(): HasOneThrough
    {
        return $this->hasOneThrough(KriteriaPpks::class, TipePpks::class, 'id', 'tipe_ppks_id', 'tipe_ppks_id');
    }

    public function kriteria_ppks(): BelongsToMany
    {
        return $this->belongsToMany(
            KriteriaPpks::class,
            'tipe_kriteria_ppks'
        )->withTimestamps();
    }

    public function alamat(): MorphOne
    {
        return $this->morphOne(Alamat::class, 'alamatable');
    }

    public function beritaAcara(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
