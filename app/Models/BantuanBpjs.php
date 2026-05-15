<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusBpjsEnum;
use App\Enums\StatusDtksEnum;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusUsulanEnum;
use App\Traits\HasKelurahanScope;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

final class BantuanBpjs extends Model
{
    use HasKelurahanScope;
    use HasWilayah;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'bantuan_bpjs';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }


    public function mutasi(): HasOne
    {
        return $this->hasOne(MutasiBpjs::class, 'bantuan_bpjs_id', 'id');
    }

    public function scopeMutasi(Builder $query): Builder
    {
        return $query->whereNotNull('is_mutasi');
    }

    public function scopeNotMutasi(Builder $query): Builder
    {
        return $query->whereNull('is_mutasi');
    }

    protected function casts(): array
    {
        return [
            'tgl_lahir' => 'date',
            'status_aktif' => StatusAktif::class,
            'status_nikah' => StatusKawinBpjsEnum::class,
            'jenis_kelamin' => JenisKelaminEnum::class,
            'status_usulan' => StatusUsulanEnum::class,
            'status_bpjs' => StatusBpjsEnum::class,
            'status_dtks' => StatusDtksEnum::class,
            'foto_ktp' => 'array',
            'alamat' => 'string',
            'is_mutasi' => 'datetime',
        ];
    }
}
