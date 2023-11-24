<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\BantuanPkhBpnt;
use App\Models\Families;
use App\Models\JenisBantuan;
use App\Models\JenisPelayanan;
use App\Models\KriteriaPelayanan;
use App\Policies\BantuanPkhBpntPolicy;
use App\Policies\FamiliesPolicy;
use App\Policies\JenisBantuanPolicy;
use App\Policies\JenisPelayananPolicy;
use App\Policies\KriteriaPelayananPolicy;
use App\Policies\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        Families::class => FamiliesPolicy::class,
        BantuanPkhBpnt::class => BantuanPkhBpntPolicy::class,
        JenisBantuan::class => JenisBantuanPolicy::class,
        JenisPelayanan::class => JenisPelayananPolicy::class,
        KriteriaPelayanan::class => KriteriaPelayananPolicy::class,
        Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
