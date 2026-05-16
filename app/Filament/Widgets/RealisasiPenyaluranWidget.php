<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Traits\HasGlobalFilters;
use App\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class RealisasiPenyaluranWidget extends BaseWidget
{
    use HasGlobalFilters;
    use HasWidgetShield;
    use InteractsWithPageFilters;

    protected static ?int $sort = -1;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $filters = $this->getFilters();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Rastra Realization
        $totalRastra = BantuanRastra::query()
            ->where('status_aktif', \App\Enums\StatusAktif::AKTIF)
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->count();

        $salurRastra = BantuanRastra::query()
            ->where('status_aktif', \App\Enums\StatusAktif::AKTIF)
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->whereHas('penyalurans', function ($query) use ($currentMonth, $currentYear): void {
                $query->whereMonth('tgl_penyerahan', $currentMonth)
                    ->whereYear('tgl_penyerahan', $currentYear);
            })
            ->count();

        // PPKS Realization
        $totalPpks = BantuanPpks::query()
            ->where('status_aktif', \App\Enums\StatusAktif::AKTIF)
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->count();

        $salurPpks = BantuanPpks::query()
            ->where('status_aktif', \App\Enums\StatusAktif::AKTIF)
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->whereHas('penyalurans', function ($query) use ($currentMonth, $currentYear): void {
                $query->whereMonth('tgl_penyerahan', $currentMonth)
                    ->whereYear('tgl_penyerahan', $currentYear);
            })
            ->count();

        $percentRastra = $totalRastra > 0 ? round(($salurRastra / $totalRastra) * 100, 1) : 0;
        $percentPpks = $totalPpks > 0 ? round(($salurPpks / $totalPpks) * 100, 1) : 0;

        return [
            Stat::make('Realisasi Rastra', $salurRastra . ' / ' . $totalRastra)
                ->description($percentRastra . '% KPM sudah menerima bantuan bulan ini')
                ->descriptionIcon($percentRastra >= 100 ? 'heroicon-m-check-badge' : 'heroicon-m-arrow-trending-up')
                ->color($percentRastra >= 100 ? 'success' : ($percentRastra > 50 ? 'warning' : 'danger')),

            Stat::make('Realisasi PPKS', $salurPpks . ' / ' . $totalPpks)
                ->description($percentPpks . '% KPM sudah menerima bantuan bulan ini')
                ->descriptionIcon($percentPpks >= 100 ? 'heroicon-m-check-badge' : 'heroicon-m-arrow-trending-up')
                ->color($percentPpks >= 100 ? 'success' : ($percentPpks > 50 ? 'warning' : 'danger')),

            Stat::make('Belum Salur (Rastra)', $totalRastra - $salurRastra)
                ->description('KPM Rastra yang tersisa periode ini')
                ->descriptionIcon('heroicon-m-clock')
                ->color($totalRastra - $salurRastra > 0 ? 'warning' : 'success'),
        ];
    }
}
