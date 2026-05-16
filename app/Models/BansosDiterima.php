<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BansosDiterima extends Model
{
    use \Spatie\Activitylog\Models\Concerns\LogsActivity;
    protected $table = 'bansos_diterima';
    protected $guarded = [];

    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function bantuan_ppks(): BelongsTo
    {
        return $this->belongsTo(BantuanPpks::class);
    }

    public function detailBantuanPpks(): HasMany
    {
        return $this->hasMany(DetailBantuanPpks::class);
    }
}
