<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\StatusBpjsEnum;
use App\Models\BantuanBpjs;
use App\Models\PesertaBpjs;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Number;

final class BantuanBpjsOverview extends BaseWidget
{
    use HasWidgetShield;
    use InteractsWithPageFilters;

    protected static bool $isDiscovered = false;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $dateRange = $this->filters['daterange'] ?? null;
        $kecamatan = $this->filters['kecamatan'] ?? null;
        $kelurahan = $this->filters['kelurahan'] ?? null;

        $all = BantuanBpjs::query()
            ->select(['created_at', 'status_bpjs', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->count();

        $verified = BantuanBpjs::query()
            ->select(['created_at', 'status_bpjs', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->where('status_bpjs', StatusBpjsEnum::BARU)
            ->count();

        $unverified = BantuanBpjs::query()
            ->select(['created_at', 'status_bpjs', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->where('status_bpjs', StatusBpjsEnum::PENGAKTIFAN)
            ->count();

        $review = BantuanBpjs::query()
            ->select(['created_at', 'status_bpjs', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->where('status_bpjs', StatusBpjsEnum::PENGALIHAN)
            ->count();

        $jamkesda = PesertaBpjs::count();

        return [
            Stat::make(
                label: 'KPM BPJS',
                value: Number::abbreviate($all, 2)
            )
                ->description('Total Seluruh KPM BPJS')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
            Stat::make(
                label: 'KPM BPJS Baru',
                value: Number::abbreviate($verified, 2)
            )
                ->description('Total KPM BPJS Baru')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make(
                label: 'Pengaktifan KPM BPJS',
                value: Number::abbreviate($unverified, 2)
            )
                ->description('Total Pengaktifan KPM BPJS')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('success'),
            Stat::make(
                label: 'Pengalihan KPM BPJS',
                value: Number::abbreviate($review, 2)
            )
                ->description('Total Pengalihan KPM BPJS')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
        ];
    }
}
