<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AlasanEnum;
use App\Enums\StatusMutasi;
use App\Enums\TipeMutasiEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class MutasiBpjs extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'mutasi_bpjs';

    protected $guarded = [];

    protected $casts = [
        'alasan_mutasi' => AlasanEnum::class,
        'status_mutasi' => StatusMutasi::class,
        'tipe_mutasi' => TipeMutasiEnum::class,
    ];

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(PesertaBpjs::class, 'peserta_bpjs_id', 'id');
    }

    public function bantuanBpjs(): BelongsTo
    {
        return $this->belongsTo(BantuanBpjs::class, 'bantuan_bpjs_id', 'id');
    }
}
