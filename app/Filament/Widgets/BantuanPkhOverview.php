<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\BantuanPkh;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Number;

final class BantuanPkhOverview extends BaseWidget
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

        $marioriwawo = BantuanPkh::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->where('kecamatan', '731201')
            ->count();

        $liliriaja = BantuanPkh::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->where('kecamatan', '731202')
            ->count();

        $lilirilau = BantuanPkh::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->where('kecamatan', '731203')
            ->count();

        $lalabata = BantuanPkh::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->where('kecamatan', '731204')
            ->count();

        $marioriawa = BantuanPkh::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->where('kecamatan', '731205')
            ->count();
        $donri2 = BantuanPkh::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->where('kecamatan', '731206')
            ->count();

        $ganra = BantuanPkh::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->where('kecamatan', '731207')
            ->count();

        $citta = BantuanPkh::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->where('kecamatan', '731208')
            ->count();

        $all = BantuanPkh::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->count();

        return [
            Stat::make(
                label: 'KPM PKH Kec. Marioriwawo',
                value: Number::abbreviate($marioriwawo, 2)
            )
                ->description('Total KPM Kec. Marioriwawo')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success'),
            Stat::make(
                label: 'KPM PKH Kec. Liliriaja',
                value: Number::abbreviate($liliriaja, 2)
            )
                ->description('Total KPM Kec. Liliriaja')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('warning'),
            Stat::make(
                label: 'KPM PKH Kec. Lilirilau',
                value: Number::abbreviate($lilirilau, 2)
            )
                ->description('Total KPM Kec. Lilirilau')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make(
                label: 'KPM PKH Kec. Lalabata',
                value: Number::abbreviate($lalabata, 2)
            )
                ->description('Total KPM Kec. Lalabata')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make(
                label: 'KPM PKH Kec. Marioriawa',
                value: Number::abbreviate($marioriawa, 2)
            )
                ->description('Total KPM Kec. Marioriawa')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),
            Stat::make(
                label: 'KPM PKH Kec. Donri Donri',
                value: Number::abbreviate($donri2, 2)
            )
                ->description('Total KPM Kec. Donri-Donri')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('gray'),
            Stat::make(
                label: 'KPM PKH Kec. Ganra',
                value: Number::abbreviate($ganra, 2)
            )
                ->description('Total KPM Kec. Ganra')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make(
                label: 'KPM PKH Kec. Citta',
                value: Number::abbreviate($citta, 2)
            )
                ->description('Total KPM Kec. Citta')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
            Stat::make(
                label: 'KPM PKH',
                value: Number::abbreviate($all, 2)
            )
                ->description('Rekap Kecamatan KPM PKH')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
        ];
    }
}
