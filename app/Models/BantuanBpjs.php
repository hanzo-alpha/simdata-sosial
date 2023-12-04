<?php

namespace App\Models;

use App\Traits\HasKeluarga;
use App\Traits\HasTambahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class BantuanBpjs extends Model
{
    use HasKeluarga, HasTambahan;

    public $timestamps = false;

    protected $table = 'bantuan_bpjs';

    protected $guarded = [];

//    protected $fillable = [
//        'dkts_id',
//        'keluarga_id',
//        'attachments',
//        'bukti_foto',
//        'dokumen',
//        'status_bpjs',
//    ];

//    protected $casts = [
//        'dkts_id' => 'string',
//        'attachments' => 'array',
//        'bukti_foto' => 'array',
//        'dokumen' => 'array',
//        'status_bpjs' => StatusAktif::class
//    ];

    public function family(): MorphMany
    {
        return $this->morphMany(Family::class, 'familyable');
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function bantuan(): MorphMany
    {
        return $this->morphMany(Bantuan::class, 'bantuanable');
    }
}
