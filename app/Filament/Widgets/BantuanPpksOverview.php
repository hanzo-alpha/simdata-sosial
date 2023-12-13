<?php

namespace App\Filament\Widgets;

use App\Enums\StatusVerifikasiEnum;
use App\Models\BantuanPpks;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class BantuanPpksOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static bool $isDiscovered = false;
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        return [
//            Stat::make(
//                label: 'Total Belum Terverifikasi',
//                value: UsulanPengaktifanTmt::query()
//                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
//                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
//                    ->where('status_verifikasi', StatusVerifikasiEnum::UNVERIFIED)
//                    ->count())
////                ->description('32k increase')
////                ->descriptionIcon('heroicon-m-arrow-trending-up')
//                ->color('success'),
            Stat::make(
                label: 'Total KPM PPKS Tidak Terverifikasi',
                value: BantuanPpks::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('status_verifikasi', StatusVerifikasiEnum::UNVERIFIED)
                    ->count())
//                ->description('32k increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
            Stat::make(
                label: 'Total KPM PPKS Terverifikasi',
                value: BantuanPpks::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('status_verifikasi', StatusVerifikasiEnum::VERIFIED)
                    ->count())
//                ->description('7% increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('success'),
            Stat::make(label: 'Total KPM PPKS Ditinjau',
                value: BantuanPpks::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('status_verifikasi', StatusVerifikasiEnum::REVIEW)
                    ->count())
//                ->description('3% increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
        ];
    }
}
