<?php

namespace App\Models;

use App\Enums\JenisKelaminEnum;
use App\Traits\HasTambahan;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasTambahan;

    public $timestamps = false;
    protected $table = 'anggota';
    protected $fillable = [
        'nokk',
        'nik',
        'nama_anggota',
        'alamat_id',
        'tempat_lahir',
        'tgl_lahir',
        'notelp',
        'jenis_bantuan_id',
        'pendidikan_terakhir_id',
        'hubungan_keluarga_id',
        'jenis_pekerjaan_id',
        'status_kawin',
        'jenis_kelamin',
    ];

    protected $casts = [
        'jenis_kelamin' => JenisKelaminEnum::class
    ];


}
