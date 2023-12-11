<?php

namespace App\Models;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusBpjsEnum;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusUsulanEnum;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaracraftTech\LaravelDateScopes\DateScopes;

class UsulanPengaktifanTmt extends Model
{
    use SoftDeletes, HasFactory, HasWilayah;

    protected $table = 'usulan_pengaktifan_tmt';

    protected $casts = [
        'tgl_lahir' => 'date',
        'status_aktif' => StatusAktif::class,
        'status_nikah' => StatusKawinBpjsEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_usulan' => StatusUsulanEnum::class,
        'status_bpjs' => StatusBpjsEnum::class,
    ];

    protected $dates = ['tgl_lahir'];
}
