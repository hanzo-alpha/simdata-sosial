<?php

namespace App\Models;

use App\Enums\StatusAktif;
use App\Enums\StatusRastra;
use App\Traits\HasKeluarga;
use App\Traits\HasTambahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class BantuanRastra extends Model
{
    use HasKeluarga, HasTambahan, SoftDeletes;

    public $timestamps = false;
    protected $table = 'bantuan_rastra';
    protected $guarded = [];

    protected $casts = [
        'dtks_id' => 'string',
        'bukti_foto' => 'array',
        'status_rastra' => StatusRastra::class,
        'status_aktif' => StatusAktif::class
    ];

//    public function family(): MorphOne
//    {
//        return $this->morphOne(Family::class, 'familyable');
//    }

    public function alamat(): MorphOne
    {
        return $this->morphOne(AlamatKeluarga::class, 'alamatable');
    }
//
//    public function bantuan(): MorphOne
//    {
//        return $this->morphOne(Bantuan::class, 'bantuanable');
//    }
}
