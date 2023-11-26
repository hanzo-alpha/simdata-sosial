<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pegawai extends Model
{
//    use HasRoles, HasPanelShield;
//    use HasRoles, HasPanelShield;

    protected $table = 'pegawai';

    protected $fillable = [
        'kantor_id',
        'nama_pegawai',
        'nik_pegawai',
        'jabatan',
        'no_telp',
        'role_id',
        'status_pegawai',
    ];

    public function kantor(): BelongsTo
    {
        return $this->belongsTo(Kantor::class);
    }

//    public function canAccessPanel(Panel $panel): bool
//    {
//        return str_ends_with($this->email, '@simdata-sosial.local') && $this->hasVerifiedEmail();
//    }

}
