<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\StatusAktif;
use App\Enums\StatusDtksEnum;
use App\Enums\StatusRastra;
use App\Enums\StatusVerifikasiEnum;
use App\Traits\HasKelurahanScope;
use App\Traits\HasTambahan;
use App\Traits\HasWilayah;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class BantuanRastra extends Model
{
    use HasKelurahanScope;
    use HasTambahan;
    use HasWilayah;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'bantuan_rastra';

    protected $guarded = [];

    public static function getLatLngAttributes(): array
    {
        return [
            'lat' => 'latitude',
            'lng' => 'longitude',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function beritaAcara(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }

    public function penyaluran(): HasOne
    {
        return $this->hasOne(PenyaluranBantuanRastra::class);
    }

    public function attachments(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }

    public function penggantiRastra(): HasOne
    {
        return $this->hasOne(PenggantiRastra::class);
    }

    protected static function booted(): void
    {
        //        static::deleted(static function (BantuanRastra $bantuanRastra): void {
        //            foreach ($bantuanRastra->foto_ktp_kk as $image) {
        //                Storage::delete("public/{$image}");
        //            }
        //        });
        //
        //        static::updating(static function (BantuanRastra $bantuanRastra): void {
        //            $imagesToDelete = array_diff($bantuanRastra->getOriginal('foto_ktp_kk'), $bantuanRastra->foto_ktp_kk);
        //
        //            foreach ($imagesToDelete as $image) {
        //                Storage::delete("public/{$image}");
        //            }
        //        });
    }

    protected function casts(): array
    {
        return [
            'dtks_id' => 'string',
            'foto_ktp_kk' => 'array',
            'pengganti_rastra' => 'array',
            'status_dtks' => StatusDtksEnum::class,
            'status_rastra' => StatusRastra::class,
            'status_aktif' => StatusAktif::class,
            'status_verifikasi' => StatusVerifikasiEnum::class,
            'keterangan' => 'string',
        ];
    }
}
