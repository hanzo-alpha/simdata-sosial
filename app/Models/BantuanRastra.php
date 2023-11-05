<?php

namespace App\Models;

use App\Enums\StatusAktif;
use App\Traits\HasKeluarga;
use Illuminate\Database\Eloquent\Model;

class BantuanRastra extends Model
{
    use HasKeluarga;

    public $timestamps = false;
    protected $table = 'bantuan_rastra';
    protected $fillable = [
        'dtks_id',
        'keluarga_id',
        'nik_penerima',
        'attachments',
        'bukti_foto',
        'dokumen',
        'location',
        'status_rastra',
    ];

    protected $casts = [
        'dtks_id' => 'string',
        'attachments' => 'array',
        'bukti_foto' => 'array',
        'dokumen' => 'array',
        'location' => 'array',
        'status_rastra' => StatusAktif::class
    ];
}
