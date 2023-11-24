<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Families extends Model
{
    use HasFactory;

    protected $fillable = [
        'dtks_id',
        'nokk',
        'nik',
        'nama_lengkap',
        'notelp',
        'tempat_lahir',
        'tgl_lahir',
        'status_family',
    ];

    protected $casts = [
        'dtks_id' => 'string',
        'tgl_lahir' => 'datetime',
    ];
}
