<?php

namespace App\Models;

use App\Traits\HasJenisBantuan;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BantuanPkhBpnt extends Model
{
    use HasFactory, HasJenisBantuan, HasWilayah;

    protected $table = 'bantuan_pkh_bpnt';

    protected $fillable = [
        'dtks_id',
        'nokk',
        'nik_ktp',
        'nama_penerima',
        'kode_wilayah',
        'tahap',
        'bansos',
        'jenis_bantuan',
        'bank',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'alamat',
        'no_rt',
        'no_rw',
        'dusun',
        'dir',
        'gelombang',
        'status_pkhbpnt',
    ];
}
