<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenyaluranBantuanRastra extends Model
{
    use SoftDeletes;

    protected $table = 'penyaluran_bantuan_rastra';

    protected $casts = [
        'tgl_penyerahan' => 'datetime',
        'foto_penyerahan' => 'array',
        'foto_ktp_kk' => 'array',
    ];

//    protected $appends = [
//        'location'
//    ];


}
