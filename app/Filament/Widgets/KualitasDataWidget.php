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

class KualitasDataWidget extends BaseWidget
{
    use HasGlobalFilters;
    use HasWidgetShield;
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $filters = $this->getFilters();

        $invalidNikRastra = BantuanRastra::query()
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->whereRaw('LENGTH(nik) != 16')
            ->count();

        $invalidNikPpks = BantuanPpks::query()
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->whereRaw('LENGTH(nik) != 16')
            ->count();

        $invalidNik = $invalidNikRastra + $invalidNikPpks;

        $emptyAlamatRastra = BantuanRastra::query()
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->where(function ($query): void {
                $query->whereNull('alamat')->orWhere('alamat', '');
            })
            ->count();

        $emptyAlamatPpks = BantuanPpks::query()
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->where(function ($query): void {
                $query->whereNull('alamat')->orWhere('alamat', '');
            })
            ->count();

        $emptyAlamat = $emptyAlamatRastra + $emptyAlamatPpks;

        $nonAktif = BantuanRastra::query()
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->where('status_aktif', \App\Enums\StatusAktif::NONAKTIF)
            ->count() + BantuanPpks::query()
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->where('status_aktif', \App\Enums\StatusAktif::NONAKTIF)
            ->count();

        return [
            Stat::make('NIK Tidak Valid', $invalidNik)
                ->description('NIK yang panjangnya tidak 16 digit')
                ->descriptionIcon('heroicon-m-identification')
                ->color($invalidNik > 0 ? 'danger' : 'success'),

            Stat::make('Alamat Kosong', $emptyAlamat)
                ->description('KPM tanpa detail alamat')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color($emptyAlamat > 0 ? 'warning' : 'success'),

            Stat::make('KPM Non-Aktif', $nonAktif)
                ->description('KPM yang saat ini tidak aktif')
                ->descriptionIcon('heroicon-m-user-minus')
                ->color('info'),
        ];
    }
}
