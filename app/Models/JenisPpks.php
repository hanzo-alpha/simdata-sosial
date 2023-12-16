<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPpks extends Model
{
    public $timestamps = false;
    protected $table = 'jenis_ppks';

    public function sub_jenis_ppks(): HasMany
    {
        return $this->hasMany(SubJenisPpks::class);
    }
}
