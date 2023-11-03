<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    public $timestamps = false;

    protected $table = 'anggaran';

    protected $fillable = [
        'nama_anggaran',
        'jumlah_anggaran',
        'tahun_anggaran',
    ];
}
