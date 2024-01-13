<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HubunganKeluarga extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'hubungan_keluarga';

    protected $fillable = [
        'nama_hubungan',
    ];
}
