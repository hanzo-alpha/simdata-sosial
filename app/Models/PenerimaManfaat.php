<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class PenerimaManfaat extends Model
{
    use HasFactory;

    protected $table = 'penerima_manfaat';
    protected $guarded = [];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    public function familyable(): MorphTo
    {
        return $this->morphTo();
    }

    public function help(): MorphTo
    {
        return $this->morphTo();
    }

    public function gambar(): MorphTo
    {
        return $this->morphTo();
    }

    public function family(): MorphToMany
    {
        return $this->morphedByMany(Family::class, 'familyable');
    }

    public function bantuan(): MorphToMany
    {
        return $this->morphedByMany(Bantuan::class, 'bantuanable');
    }

    public function image(): MorphToMany
    {
        return $this->morphedByMany(Image::class, 'imageable');
    }
}
