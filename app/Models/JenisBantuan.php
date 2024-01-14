<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class JenisBantuan extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'jenis_bantuan';

    protected $fillable = [
        'nama_bantuan',
        'alias',
        'warna',
        'deskripsi',
    ];
}
