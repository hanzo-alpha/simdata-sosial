<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kantor extends Model
{
    public $timestamps = false;
    protected $table = 'kantor';
    protected $fillable = [
        'user_id',
        'nama_kantor',
        'pegawai_id',
        'alamat',
        'no_telp',
    ];
}
