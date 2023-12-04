<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPsks extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nama_psks',
        'alias',
        'deskripsi',
    ];
}
