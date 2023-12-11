<?php

namespace App\Models;

use App\Enums\AlasanEnum;
use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsulanMutasiTmt extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'usulan_mutasi_tmt';

    protected $casts = [
        'jenis_kelamin' => JenisKelaminEnum::class,
        'alasan_mutasi' => AlasanEnum::class,
        'status_mutasi' => StatusAktif::class
    ];
}
