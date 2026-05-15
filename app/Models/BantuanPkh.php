<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\StatusDtksEnum;
use App\Enums\StatusPkhBpntEnum;
use App\Traits\HasJenisBantuan;
use App\Traits\HasKelurahanScope;
use App\Traits\HasWilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class BantuanPkh extends Model
{
    use HasJenisBantuan;
    use HasKelurahanScope;
    use HasWilayah;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'bantuan_pkh';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }


    protected function casts(): array
    {
        return [
            'dtks_id' => 'string',
            'nominal' => MoneyCast::class,
            'status_pkh' => StatusPkhBpntEnum::class,
            'status_dtks' => StatusDtksEnum::class,
        ];
    }
}
