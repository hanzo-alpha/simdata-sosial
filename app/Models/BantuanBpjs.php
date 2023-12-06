<?php

namespace App\Models;

use App\Enums\StatusBpjsEnum;
use App\Traits\HasKeluarga;
use App\Traits\HasTambahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class BantuanBpjs extends Model
{
    use HasKeluarga, HasTambahan;

    public $timestamps = false;

    protected $table = 'bantuan_bpjs';

    protected $guarded = [];

    protected $casts = [
        'dkts_id' => 'string',
        'attachments' => 'array',
        'bukti_foto' => 'array',
        'dokumen' => 'array',
        'status_bpjs' => StatusBpjsEnum::class
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
