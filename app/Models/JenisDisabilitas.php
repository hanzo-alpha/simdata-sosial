<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisDisabilitas extends Model
{
    protected $table = 'jenis_disabilitas';

    public function sub_jenis_disabilitas(): HasMany
    {
        return $this->hasMany(SubJenisDisabilitas::class);
    }
}
