<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class PendidikanTerakhir extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'pendidikan_terakhir';

    protected $fillable = [
        'nama_pendidikan',
    ];
}
