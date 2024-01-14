<?php

namespace App\Models;

use App\Enums\AlasanEnum;
use App\Enums\StatusMutasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutasiBpjs extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mutasi_bpjs';

    protected $guarded = [];

    protected $casts = [
        'alasan_mutasi' => AlasanEnum::class,
        'status_mutasi' => StatusMutasi::class,
    ];

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(PesertaBpjs::class, 'peserta_bpjs_id', 'id');
    }
}
