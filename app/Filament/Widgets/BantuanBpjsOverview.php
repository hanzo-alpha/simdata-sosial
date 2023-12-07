<?php

namespace App\Filament\Widgets;

use App\Enums\StatusBpjsEnum;
use App\Models\BantuanBpjs;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class BantuanBpjsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        return [
            Stat::make(
                label: 'Total Bantuan BPJS Baru',
                value: BantuanBpjs::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('status_bpjs', StatusBpjsEnum::BARU)
                    ->count())
                ->description('32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make(
                label: 'Total Bantuan Pengaktifan BPJS',
                value: BantuanBpjs::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('status_bpjs', StatusBpjsEnum::PENGAKTIFAN)
                    ->count())
                ->description('7% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make(label: 'Total Bantuan Pengalihan BPJS',
                value: BantuanBpjs::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('status_bpjs', StatusBpjsEnum::PENGALIHAN)
                    ->count())
                ->description('3% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
