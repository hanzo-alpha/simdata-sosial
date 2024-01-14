<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusBpjsEnum;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusUsulanEnum;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class BantuanBpjs extends Model
{
    use HasWilayah;
    use SoftDeletes;

    protected $table = 'bantuan_bpjs';

    protected $guarded = [];

    protected $casts = [
        'tgl_lahir' => 'date',
        'status_aktif' => StatusAktif::class,
        'status_nikah' => StatusKawinBpjsEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_usulan' => StatusUsulanEnum::class,
        'status_bpjs' => StatusBpjsEnum::class,
        'foto_ktp' => 'array',
        'alamat' => 'string',
    ];
}
