<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\StatusVerifikasiEnum;
use App\Models\BantuanPpks;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Number;

final class BantuanPpksOverview extends BaseWidget
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

        $unverified = BantuanPpks::query()
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '>=', $dates[0])
                    ->whereDate('created_at', '<=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->whereHas('alamat', fn(Builder $query) => $query->whereHas('kec', fn(Builder $query) => $query->where('code', $kecamatan))))
            ->when($kelurahan, fn(Builder $query) => $query->whereHas('alamat', fn(Builder $query) => $query->whereHas('kel', fn(Builder $query) => $query->where('code', $kelurahan))))
            ->where('status_verifikasi', StatusVerifikasiEnum::UNVERIFIED)
            ->count();

        $verified = BantuanPpks::query()
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->whereHas('alamat', fn(Builder $query) => $query->whereHas('kec', fn(Builder $query) => $query->where('code', $kecamatan))))
            ->when($kelurahan, fn(Builder $query) => $query->whereHas('alamat', fn(Builder $query) => $query->whereHas('kel', fn(Builder $query) => $query->where('code', $kelurahan))))
            ->where('status_verifikasi', StatusVerifikasiEnum::VERIFIED)
            ->count();

        $review = BantuanPpks::query()
            ->when($dateRange, function (Builder $query) use ($dateRange) {
                $dates = explode('-', $dateRange);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($kecamatan, fn(Builder $query) => $query->whereHas('alamat', fn(Builder $query) => $query->whereHas('kec', fn(Builder $query) => $query->where('code', $kecamatan))))
            ->when($kelurahan, fn(Builder $query) => $query->whereHas('alamat', fn(Builder $query) => $query->whereHas('kel', fn(Builder $query) => $query->where('code', $kelurahan))))
            ->where('status_verifikasi', StatusVerifikasiEnum::REVIEW)
            ->count();

        return [
            Stat::make(
                label: 'KPM PPKS Tidak Terverifikasi',
                value: Number::abbreviate($unverified, 2)
            )
                ->description('Total KPM PPKS Tidak Terverifikasi')
                ->descriptionIcon('heroicon-o-minus-circle')
                ->color('danger'),
            Stat::make(
                label: 'KPM PPKS Terverifikasi',
                value: Number::abbreviate($verified, 2)
            )
                ->description('Total KPM PPKS Terverifikasi')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success'),
            Stat::make(
                label: 'KPM PPKS Ditinjau',
                value: Number::abbreviate($review, 2)
            )
                ->description('Total KPM PPKS Ditinjau')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color('warning'),
        ];
    }
}
