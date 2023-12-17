<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubJenisDisabilitas extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'sub_jenis_disabilitas';
//    protected $fillable = [
//        'jenis_disabilitas_id',
//        'nama_sub_jenis',
//    ];

    public function jenis_disabilitas(): BelongsTo
    {
        return $this->belongsTo(JenisDisabilitas::class);
    }
}
