<?php

namespace App\Models;

use App\Enums\StatusDtksEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BnbaRastra extends Model
{
    use SoftDeletes;

    protected $table = 'bnba_rastra';

    protected $guarded = [];

    protected $casts = [
        'dtks_id' => StatusDtksEnum::class,
        'status_dtks' => StatusDtksEnum::class,
    ];
}
