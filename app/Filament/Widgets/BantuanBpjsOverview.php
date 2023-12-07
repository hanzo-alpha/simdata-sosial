<?php

namespace App\Filament\Widgets;

use App\Enums\StatusBpjsEnum;
use App\Models\BantuanBpjs;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BantuanBpjsOverview extends BaseWidget
{
    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Bantuan BPJS Baru', BantuanBpjs::query()->where('status_bpjs', StatusBpjsEnum::BARU)
                ->count())
                ->description('32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Bantuan Pengaktifan BPJS', BantuanBpjs::query()->where('status_bpjs',
                StatusBpjsEnum::PENGAKTIFAN)->count())
                ->description('7% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Total Bantuan Pengalihan BPJS', BantuanBpjs::query()->where('status_bpjs',
                StatusBpjsEnum::PENGALIHAN)
                ->count())
                ->description('3% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
