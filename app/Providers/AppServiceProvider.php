<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\Carbon;
use Filament\Tables\Columns\Column;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Number;

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
        Column::configureUsing(function (Column $column): void {
            $column
                ->toggleable()
                ->sortable()
                ->searchable();
        });

        Number::useLocale('id');

        Model::shouldBeStrict( ! $this->app->isProduction());
        Model::unguard();

        setlocale(LC_ALL, 'IND');
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}
