<?php

namespace App\Models;

use App\Enums\StatusAktif;
use App\Traits\HasKeluarga;
use Illuminate\Database\Eloquent\Model;

class BantuanBpjs extends Model
{
    use HasKeluarga;

    public $timestamps = false;

    protected $fillable = [
        'dkts_id',
        'keluarga_id',
        'attachments',
        'bukti_foto',
        'dokumen',
        'status_bpjs',
    ];

    protected $casts = [
        'dkts_id' => 'string',
        'attachments' => 'array',
        'bukti_foto' => 'array',
        'dokumen' => 'array',
        'status_bpjs' => StatusAktif::class
    ];
}
