<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

final class Provinsi extends Model
{
    use HasRelationships;

    protected $table = 'provinsi';

    protected $primaryKey = 'code';

    protected $fillable = [
        'code',
        'name',
    ];

    public function kab(): HasMany
    {
        return $this->hasMany(Kabupaten::class, 'provinsi_code', 'provinsi_code');
    }

    public function kec(): HasManyThrough
    {
        return $this->hasManyThrough(Kecamatan::class, Kabupaten::class, 'provinsi_code', 'kabupaten_code');
    }

    public function kel(): HasManyDeep
    {
        return $this->hasManyDeep(
            Kelurahan::class,
            [Kabupaten::class, Kecamatan::class],
            ['provinsi_code', 'kabupaten_code', 'kecamatan_code'],
            //            ['city_code', 'district_code', 'province_code']
        );
    }
}
