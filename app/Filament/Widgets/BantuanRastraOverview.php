<?php

namespace App\Filament\Widgets;

use App\Enums\StatusRastra;
use App\Models\BantuanRastra;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BantuanRastraOverview extends BaseWidget
{
    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Bantuan Baru RASTRA', BantuanRastra::query()->where('status_rastra', StatusRastra::BARU)
                ->count())
                ->description('32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Bantuan Pengganti Rastra', BantuanRastra::query()->where('status_rastra',
                StatusRastra::PENGGANTI)
                ->count())
                ->description('7% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Total Bantuan Rastra',
                BantuanRastra::query()->count())
                ->description('3% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
