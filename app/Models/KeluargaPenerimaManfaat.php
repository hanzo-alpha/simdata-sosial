<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeluargaPenerimaManfaat extends Model
{
    protected $table = 'keluarga_penerima_manfaat';

    public function bantuan_bpjs(): BelongsTo
    {
        return $this->belongsTo(BantuanBpjs::class);
    }


}
