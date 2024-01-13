<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaBpjs extends Model
{
    use HasFactory;

    protected $table = 'peserta_bpjs';

    protected $guarded = [];

    protected $casts = [
        'bulan' => 'integer',
        'tahun' => 'integer',
    ];
}
