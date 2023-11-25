<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Alamat;
use App\Models\Anggaran;
use App\Models\Anggota;
use App\Models\BantuanBpjs;
use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Models\HubunganKeluarga;
use App\Models\JenisPekerjaan;
use App\Models\JenisPelayanan;
use App\Models\Keluarga;
use App\Models\KriteriaPelayanan;
use App\Models\PendidikanTerakhir;
use App\Models\PenggantiRastra;
use App\Policies\ActivityPolicy;
use App\Policies\AlamatPolicy;
use App\Policies\AnggaranPolicy;
use App\Policies\AnggotaPolicy;
use App\Policies\BantuanBpjsPolicy;
use App\Policies\BantuanBpntPolicy;
use App\Policies\BantuanPkhPolicy;
use App\Policies\BantuanPpksPolicy;
use App\Policies\BantuanRastraPolicy;
use App\Policies\HubunganKeluargaPolicy;
use App\Policies\JenisPekerjaanPolicy;
use App\Policies\JenisPelayananPolicy;
use App\Policies\KeluargaPolicy;
use App\Policies\KriteriaPelayananPolicy;
use App\Policies\PendidikanTerakhirPolicy;
use App\Policies\PenggantiRastraPolicy;
use App\Policies\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        BantuanPkh::class => BantuanPkhPolicy::class,
        Activity::class => ActivityPolicy::class,
        Alamat::class => AlamatPolicy::class,
        Anggaran::class => AnggaranPolicy::class,
        Anggota::class => AnggotaPolicy::class,
        BantuanBpjs::class => BantuanBpjsPolicy::class,
        BantuanBpnt::class => BantuanBpntPolicy::class,
        BantuanPpks::class => BantuanPpksPolicy::class,
        BantuanRastra::class => BantuanRastraPolicy::class,
        HubunganKeluarga::class => HubunganKeluargaPolicy::class,
        JenisPekerjaan::class => JenisPekerjaanPolicy::class,
        JenisPelayanan::class => JenisPelayananPolicy::class,
        Keluarga::class => KeluargaPolicy::class,
        KriteriaPelayanan::class => KriteriaPelayananPolicy::class,
        PendidikanTerakhir::class => PendidikanTerakhirPolicy::class,
        PenggantiRastra::class => PenggantiRastraPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
