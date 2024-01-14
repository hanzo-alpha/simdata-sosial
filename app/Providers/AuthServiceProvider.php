<?php

declare(strict_types=1);

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Alamat;
use App\Models\BantuanBpjs;
use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Models\HubunganKeluarga;
use App\Models\JenisBantuan;
use App\Models\JenisPekerjaan;
use App\Models\PendidikanTerakhir;
use App\Models\PenggantiRastra;
use App\Models\SubJenisDisabilitas;
use App\Models\User;
use App\Policies\ActivityPolicy;
use App\Policies\AlamatPolicy;
use App\Policies\BantuanBpjsPolicy;
use App\Policies\BantuanBpntPolicy;
use App\Policies\BantuanPkhPolicy;
use App\Policies\BantuanPpksPolicy;
use App\Policies\BantuanRastraPolicy;
use App\Policies\HubunganKeluargaPolicy;
use App\Policies\JenisBantuanPolicy;
use App\Policies\JenisPekerjaanPolicy;
use App\Policies\KriteriaPelayananPolicy;
use App\Policies\MediaPolicy;
use App\Policies\PendidikanTerakhirPolicy;
use App\Policies\PenggantiRastraPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

final class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        Activity::class => ActivityPolicy::class,
        Alamat::class => AlamatPolicy::class,
        BantuanBpjs::class => BantuanBpjsPolicy::class,
        BantuanBpnt::class => BantuanBpntPolicy::class,
        BantuanPkh::class => BantuanPkhPolicy::class,
        BantuanPpks::class => BantuanPpksPolicy::class,
        BantuanRastra::class => BantuanRastraPolicy::class,
        HubunganKeluarga::class => HubunganKeluargaPolicy::class,
        JenisBantuan::class => JenisBantuanPolicy::class,
        JenisPekerjaan::class => JenisPekerjaanPolicy::class,
        SubJenisDisabilitas::class => KriteriaPelayananPolicy::class,
        MediaPolicy::class => MediaPolicy::class,
        PendidikanTerakhir::class => PendidikanTerakhirPolicy::class,
        PenggantiRastra::class => PenggantiRastraPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void {}
}
