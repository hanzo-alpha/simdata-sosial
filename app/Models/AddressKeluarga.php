<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AddressKeluarga extends Model
{
    protected $table = 'addresses_keluarga';

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
