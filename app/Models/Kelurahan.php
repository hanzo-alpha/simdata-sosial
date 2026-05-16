<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

final class Kelurahan extends Model
{
    use HasFactory;
    use HasRelationships;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'kelurahan';

    protected $primaryKey = 'code';

    //    protected $with = ['bantuanRastras'];

    protected $fillable = [
        'kecamatan_code',
        'name',
    ];

    public function prov(): HasOneDeep
    {
        return $this->hasOneDeep(
            Provinsi::class,
            [Kecamatan::class, Kabupaten::class],
            ['code', 'code', 'code'],
            ['district_code', 'city_code', 'province_code'],
        );
    }

    public function kab(): HasOneThrough
    {
        return $this->hasOneThrough(
            Kabupaten::class,
            Kecamatan::class,
            'code',
            'code',
            'kecamatan_code',
            'kabupaten_code',
        );
    }

    public function kec(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_code', 'code');
    }

    protected static function booted(): void
    {
        static::saved(function ($kelurahan): void {
            cache()->forget('kelurahan_options_all');
            cache()->forget('kelurahan_options_' . $kelurahan->kecamatan_code);
        });
        static::deleted(function ($kelurahan): void {
            cache()->forget('kelurahan_options_all');
            cache()->forget('kelurahan_options_' . $kelurahan->kecamatan_code);
        });
    }

    //    public function bantuanRastras(): BelongsTo
    //    {
    //        return $this->belongsTo(BantuanRastra::class, 'code', 'kelurahan');
    //    }
}
