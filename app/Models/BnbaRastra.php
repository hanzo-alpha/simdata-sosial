<?php

namespace App\Models;

use App\Enums\StatusDtksEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BnbaRastra extends Model
{
    use SoftDeletes;

    protected $table = 'bnba_rastra';

    protected $guarded = [];

    protected $casts = [
        'status_dtks' => StatusDtksEnum::class,
    ];

    public function scopeStatusDtks(Builder $query, $status): void
    {
        $query->where('status_dtks', '=', $status);
    }
}
