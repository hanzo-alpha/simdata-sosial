<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasKelurahanScope;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class BantuanBpnt extends Model
{
    use HasKelurahanScope;
    use HasWilayah;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'bantuan_bpnt';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }


    protected function casts(): array
    {
        return [
            'provinsi' => 'string',
            'kabupaten' => 'string',
            'kecamatan' => 'string',
            'kelurahan' => 'string',
        ];
    }
}
