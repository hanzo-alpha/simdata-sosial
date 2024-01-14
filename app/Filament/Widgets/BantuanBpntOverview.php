<?php

namespace App\Filament\Widgets;

use App\Models\BantuanBpnt;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class BantuanBpntOverview extends BaseWidget
{
    use InteractsWithPageFilters, HasWidgetShield;

    protected static bool $isDiscovered = false;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $dateRange = $this->filters['daterange'] ?? null;
        $kecamatan = $this->filters['kecamatan'] ?? null;
        $kelurahan = $this->filters['kelurahan'] ?? null;

        $marioriwawo = BantuanBpnt::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                return $query->where('kecamatan', $kecamatan);
            })
            ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                return $query->where('kelurahan', $kelurahan);
            })
            ->where('kecamatan', '731201')
            ->count();

        $liliriaja = BantuanBpnt::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                return $query->where('kecamatan', $kecamatan);
            })
            ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                return $query->where('kelurahan', $kelurahan);
            })
            ->where('kecamatan', '731202')
            ->count();

        $lilirilau = BantuanBpnt::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                return $query->where('kecamatan', $kecamatan);
            })
            ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                return $query->where('kelurahan', $kelurahan);
            })
            ->where('kecamatan', '731203')
            ->count();

        $lalabata = BantuanBpnt::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                return $query->where('kecamatan', $kecamatan);
            })
            ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                return $query->where('kelurahan', $kelurahan);
            })
            ->where('kecamatan', '731204')
            ->count();

        $marioriawa = BantuanBpnt::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                return $query->where('kecamatan', $kecamatan);
            })
            ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                return $query->where('kelurahan', $kelurahan);
            })
            ->where('kecamatan', '731205')
            ->count();
        $donri2 = BantuanBpnt::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                return $query->where('kecamatan', $kecamatan);
            })
            ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                return $query->where('kelurahan', $kelurahan);
            })
            ->where('kecamatan', '731206')
            ->count();

        $ganra = BantuanBpnt::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                return $query->where('kecamatan', $kecamatan);
            })
            ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                return $query->where('kelurahan', $kelurahan);
            })
            ->where('kecamatan', '731207')
            ->count();

        $citta = BantuanBpnt::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                return $query->where('kecamatan', $kecamatan);
            })
            ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                return $query->where('kelurahan', $kelurahan);
            })
            ->where('kecamatan', '731208')
            ->count();

        $all = BantuanBpnt::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                return $query->where('kecamatan', $kecamatan);
            })
            ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                return $query->where('kelurahan', $kelurahan);
            })
            ->count();

        return [
            Stat::make(
                label: 'KPM BPNT Kec. Marioriwawo',
                value: \Number::abbreviate($marioriwawo))
                ->description('Total KPM Kec. Marioriwawo')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success'),
            Stat::make(
                label: 'KPM BPNT Kec. Liliriaja',
                value: \Number::abbreviate($liliriaja))
                ->description('Total KPM Kec. Liliriaja')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('warning'),
            Stat::make(
                label: 'KPM BPNT Kec. Lilirilau',
                value: \Number::abbreviate($lilirilau))
                ->description('Total KPM Kec. Lilirilau')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make(label: 'KPM BPNT Kec. Lalabata',
                value: \Number::abbreviate($lalabata))
                ->description('Total KPM Kec. Lalabata')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make(label: 'KPM BPNT Kec. Marioriawa',
                value: \Number::abbreviate($marioriawa))
                ->description('Total KPM Kec. Marioriawa')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),
            Stat::make(label: 'KPM BPNT Kec. Donri Donri',
                value: \Number::abbreviate($donri2))
                ->description('Total KPM Kec. Donri-Donri')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('gray'),
            Stat::make(label: 'KPM BPNT Kec. Ganra',
                value: \Number::abbreviate($ganra))
                ->description('Total KPM Kec. Ganra')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make(label: 'KPM BPNT Kec. Citta',
                value: \Number::abbreviate($citta))
                ->description('Total KPM Kec. Citta')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
            Stat::make(label: 'KPM BPNT',
                value: \Number::abbreviate($all))
                ->description('Rekap Kecamatan KPM BPNT')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
        ];
    }
}
