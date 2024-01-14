<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict($this->app->isLocal());
        Model::unguard();

        setlocale(LC_ALL, 'IND');
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

    }
}
