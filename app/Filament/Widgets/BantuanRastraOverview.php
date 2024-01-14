<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\StatusVerifikasiEnum;
use App\Models\BantuanRastra;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

final class BantuanRastraOverview extends BaseWidget
{
    use HasWidgetShield;

    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        $dateRange = $this->filters['daterange'] ?? null;
        $kecamatan = $this->filters['kecamatan'] ?? null;
        $kelurahan = $this->filters['kelurahan'] ?? null;

        return [
            Stat::make(
                label: 'KPM RASTRA Tidak Terverifikasi',
                value: BantuanRastra::query()
                    ->when($dateRange, function (Builder $query) use ($dateRange) {
                        $dates = explode('-', $dateRange);

                        return $query
                            ->whereDate('created_at', '>=', $dates[0])
                            ->whereDate('created_at', '<=', $dates[1]);
                    })
                    ->when($kecamatan, fn(Builder $query) => $query->whereHas('alamat', fn(Builder $query) => $query->whereHas('kec', fn(Builder $query) => $query->where('code', $kecamatan))))
                    ->when($kelurahan, fn(Builder $query) => $query->whereHas('alamat', fn(Builder $query) => $query->whereHas('kel', fn(Builder $query) => $query->where('code', $kelurahan))))
                    ->where('status_verifikasi', StatusVerifikasiEnum::UNVERIFIED)
                    ->count()
            )
                ->description('Total KPM RASTRA yang belum terverifikasi')
                ->descriptionIcon('heroicon-o-document-minus')
                ->color('danger'),
            Stat::make(
                label: 'KPM RASTRA Terverifikasi',
                value: BantuanRastra::query()
                    ->when($dateRange, function (Builder $query) use ($dateRange) {
                        $dates = explode('-', $dateRange);

                        return $query
                            ->whereDate('created_at', '>=', $dates[0])
                            ->whereDate('created_at', '<=', $dates[1]);
                    })
                    ->when($kecamatan, fn(Builder $query) => $query->whereHas('alamat', fn(Builder $query) => $query->whereHas('kec', fn(Builder $query) => $query->where('code', $kecamatan))))
                    ->when($kelurahan, fn(Builder $query) => $query->whereHas('alamat', fn(Builder $query) => $query->whereHas('kel', fn(Builder $query) => $query->where('code', $kelurahan))))
                    ->where('status_verifikasi', StatusVerifikasiEnum::VERIFIED)
                    ->count()
            )
                ->description('Total KPM RASTRA yang sudah terverifikasi')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make(
                label: 'KPM RASTRA Ditinjau',
                value: BantuanRastra::query()
                    ->when($dateRange, function (Builder $query) use ($dateRange) {
                        $dates = explode('-', $dateRange);

                        return $query
                            ->whereDate('created_at', '>=', $dates[0])
                            ->whereDate('created_at', '<=', $dates[1]);
                    })
                    ->when($kecamatan, fn(Builder $query) => $query->whereHas('alamat', fn(Builder $query) => $query->whereHas('kec', fn(Builder $query) => $query->where('code', $kecamatan))))
                    ->when($kelurahan, fn(Builder $query) => $query->whereHas('alamat', fn(Builder $query) => $query->whereHas('kel', fn(Builder $query) => $query->where('code', $kelurahan))))
                    ->where('status_verifikasi', StatusVerifikasiEnum::REVIEW)
                    ->count()
            )
                ->description('Total KPM RASTRA dalam proses peninjauan')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color('info'),
        ];
    }
}
