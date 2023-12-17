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
        $dateRange = $this->filters['daterange'] ?? null;
        $kecamatan = $this->filters['kecamatan'] ?? null;
        $kelurahan = $this->filters['kelurahan'] ?? null;

        return [
            Stat::make(
                label: 'Total KPM PPKS Tidak Terverifikasi',
                value: BantuanPpks::query()
                    ->when($dateRange, function (Builder $query) use ($dateRange) {
                        $dates = explode('-', $dateRange);
                        return $query
                            ->whereDate('created_at', '>=', $dates[0])
                            ->whereDate('created_at', '<=', $dates[1]);
                    })
                    ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                        return $query->whereHas('alamat', function (Builder $query) use ($kecamatan) {
                            return $query->whereHas('kec', function (Builder $query) use ($kecamatan) {
                                return $query->where('code', $kecamatan);
                            });
                        });
                    })
                    ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                        return $query->whereHas('alamat', function (Builder $query) use ($kelurahan) {
                            return $query->whereHas('kel', function (Builder $query) use ($kelurahan) {
                                return $query->where('code', $kelurahan);
                            });
                        });
                    })
                    ->where('status_verifikasi', StatusVerifikasiEnum::UNVERIFIED)
                    ->count())
//                ->description('32k increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
            Stat::make(
                label: 'Total KPM PPKS Terverifikasi',
                value: BantuanPpks::query()
                    ->when($dateRange, function (Builder $query) use ($dateRange) {
                        $dates = explode('-', $dateRange);
                        return $query
                            ->whereDate('created_at', '<=', $dates[0])
                            ->whereDate('created_at', '>=', $dates[1]);
                    })
                    ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                        return $query->whereHas('alamat', function (Builder $query) use ($kecamatan) {
                            return $query->whereHas('kec', function (Builder $query) use ($kecamatan) {
                                return $query->where('code', $kecamatan);
                            });
                        });
                    })
                    ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                        return $query->whereHas('alamat', function (Builder $query) use ($kelurahan) {
                            return $query->whereHas('kel', function (Builder $query) use ($kelurahan) {
                                return $query->where('code', $kelurahan);
                            });
                        });
                    })
                    ->where('status_verifikasi', StatusVerifikasiEnum::VERIFIED)
                    ->count())
//                ->description('7% increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('success'),
            Stat::make(label: 'Total KPM PPKS Ditinjau',
                value: BantuanPpks::query()
                    ->when($dateRange, function (Builder $query) use ($dateRange) {
                        $dates = explode('-', $dateRange);
                        return $query
                            ->whereDate('created_at', '<=', $dates[0])
                            ->whereDate('created_at', '>=', $dates[1]);
                    })
                    ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                        return $query->whereHas('alamat', function (Builder $query) use ($kecamatan) {
                            return $query->whereHas('kec', function (Builder $query) use ($kecamatan) {
                                return $query->where('code', $kecamatan);
                            });
                        });
                    })
                    ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                        return $query->whereHas('alamat', function (Builder $query) use ($kelurahan) {
                            return $query->whereHas('kel', function (Builder $query) use ($kelurahan) {
                                return $query->where('code', $kelurahan);
                            });
                        });
                    })
                    ->where('status_verifikasi', StatusVerifikasiEnum::REVIEW)
                    ->count())
//                ->description('3% increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
        ];
    }
}
