<?php

namespace App\Models;

use App\Enums\StatusAktif;
use App\Traits\HasTambahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class BantuanRastra extends Model
{
    use HasTambahan;

    public $timestamps = false;
    protected $table = 'bantuan_rastra';
    protected $guarded = [];

//    protected $fillable = [
//        'dtks_id',
//        'keluarga_id',
//        'nik_penerima',
//        'attachments',
//        'bukti_foto',
//        'dokumen',
//        'location',
//        'status_rastra',
//    ];

    protected $casts = [
        'dtks_id' => 'string',
        'attachments' => 'array',
        'bukti_foto' => 'array',
        'dokumen' => 'array',
        'location' => 'array',
        'status_rastra' => StatusAktif::class
    ];

    public function family(): MorphOne
    {
        return $this->morphOne(Family::class, 'familyable');
    }

    public function alamat(): MorphOne
    {
        return $this->morphOne(AlamatKeluarga::class, 'alamatable');
    }

    public function bantuan(): MorphOne
    {
        return $this->morphOne(Bantuan::class, 'bantuanable');
    }
}
