<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class HubunganKeluarga extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'hubungan_keluarga';

    protected $fillable = [
        'nama_hubungan',
    ];
}
