<?php

namespace App\Models;

use App\Enums\StatusPenandatangan;
use Illuminate\Database\Eloquent\Model;

class Penandatangan extends Model
{
    protected $table = 'penandatangan';

    protected $guarded = [];

    protected $casts = [
        'status_penandatangan' => StatusPenandatangan::class
    ];
}
