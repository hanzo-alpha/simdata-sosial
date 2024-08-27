<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\StatusPenyaluran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenyaluranBantuanPpks extends Model
{
    use SoftDeletes;

    protected $casts = [
        'tgl_penyerahan' => 'datetime',
        'foto_penyerahan' => 'array',
        'status_penyaluran' => StatusPenyaluran::class,
    ];

    protected $appends = [
        'location',
    ];

    protected $with = ['bantuan_ppks'];

    public static function getLatLngAttributes(): array
    {
        return [
            'lat' => 'lat',
            'lng' => 'lng',
        ];
    }

    public static function getComputedLocation(): string
    {
        return 'location';
    }

    public function bantuan_ppks(): BelongsTo
    {
        return $this->belongsTo(BantuanPpks::class);
    }

    public function getLocationAttribute(): array
    {
        return [
            'lat' => (float) $this->lat,
            'lng' => (float) $this->lng,
        ];
    }

    public function setLocationAttribute(?array $location): void
    {
        if (is_array($location)) {
            $this->attributes['lat'] = $location['lat'];
            $this->attributes['lng'] = $location['lng'];
            unset($this->attributes['location']);
        }
    }
}
