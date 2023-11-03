<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPekerjaan extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'jenis_pekerjaan';

    protected $fillable = [
        'nama_pekerjaan',
    ];
}
