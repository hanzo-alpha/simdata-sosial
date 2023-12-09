<?php
declare(strict_types=1);

namespace App\Models;

use App\Enums\AlasanEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MutasiBpjs extends Model
{
    protected $table = 'mutasi_bantuan_bpjs';
    protected $guarded = [];

    protected $casts = [
        'alasan_mutasi' => AlasanEnum::class
    ];

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(BantuanBpjs::class);
    }

    public function bantuanbpjs(): BelongsTo
    {
        return $this->belongsTo(BantuanBpjs::class);
    }

}
