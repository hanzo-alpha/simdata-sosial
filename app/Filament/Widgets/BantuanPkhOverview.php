<?php

namespace App\Filament\Widgets;

use App\Models\BantuanPkh;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class BantuanPkhOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static bool $isDiscovered = false;
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        return [
            Stat::make(
                label: 'Total KPM Kec. Marioriwawo',
                value: BantuanPkh::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('kecamatan', '731201')
                    ->count())
//                ->description('32k increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make(
                label: 'Total KPM PKH Kec. Liliriaja',
                value: BantuanPkh::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('kecamatan', '731202')
                    ->count())
//                ->description('32k increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make(
                label: 'Total KPM PKH Kec. Lilirilau',
                value: BantuanPkh::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('kecamatan', '731203')
                    ->count())
//                ->description('7% increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make(label: 'Total KPM PKH Kec. Lalabata',
                value: BantuanPkh::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('kecamatan', '731204')
                    ->count())
//                ->description('3% increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make(label: 'Total KPM PKH Kec. Marioriawa',
                value: BantuanPkh::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('kecamatan', '731205')
                    ->count())
//                ->description('3% increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make(label: 'Total KPM PKH Kec. Donri Donri',
                value: BantuanPkh::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('kecamatan', '731206')
                    ->count())
//                ->description('3% increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make(label: 'Total KPM PKH Kec. Ganra',
                value: BantuanPkh::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('kecamatan', '731207')
                    ->count())
//                ->description('3% increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make(label: 'Total KPM PKH Kec. Citta',
                value: BantuanPkh::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('kecamatan', '731208')
                    ->count())
//                ->description('3% increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
