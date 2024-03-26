<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\StatusUsulanEnum;
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

    protected static function getQuery(array $filter): Builder
    {
        return BantuanBpjs::query()
            ->select(['created_at', 'status_bpjs', 'kecamatan', 'kelurahan'])
            ->when($filter['dateRange'], function (Builder $query) use ($filter) {
                $dates = explode('-', $filter['dateRange']);

                return $query
                    ->whereDate('created_at', '<=', $dates[0])
                    ->whereDate('created_at', '>=', $dates[1]);
            })
            ->when($filter['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filter['kecamatan']))
            ->when($filter['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filter['kelurahan']));
    }

    protected function getStats(): array
    {
        $dateRange = $this->filters['daterange'] ?? null;
        $kecamatan = $this->filters['kecamatan'] ?? null;
        $kelurahan = $this->filters['kelurahan'] ?? null;

        $query = static::getQuery($this->getFilter());

        $all = $query->count();
        $berhasil = $query->where('status_usulan', StatusUsulanEnum::BERHASIL)->count();
        $gagal = $query->where('status_usulan', StatusUsulanEnum::GAGAL)->count();
        $review = $query->where('status_usulan', StatusUsulanEnum::ONPROGRESS)->count();

        //        dd($all, $berhasil, $gagal, $review);


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
            ->where('status_usulan', StatusUsulanEnum::BERHASIL)
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
            ->where('status_usulan', StatusUsulanEnum::GAGAL)
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
            ->where('status_usulan', StatusUsulanEnum::ONPROGRESS)
            ->count();

        $jamkesda = PesertaBpjs::count();

        return [
            Stat::make(
                label: 'KPM BPJS',
                value: Number::format($jamkesda, 2, 0, 'id') . ' KPM'
            )
                ->description('Total Seluruh Usulan BPJS')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
            Stat::make(
                label: 'Usulan BPJS Berhasil',
                value: Number::format($verified, 2, 2, 'id') . ' KPM'
            )
                ->description('Jumlah Usulan BPJS Berhasil')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make(
                label: 'Usulan BPJS Gagal',
                value: Number::format($unverified, 2, 2, 'id') . ' KPM'
            )
                ->description('Jumlah Usulan BPJS Gagal')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('success'),
            Stat::make(
                label: 'Usulan BPJS Sedang Proses',
                value: Number::format($review, 2, 2, 'id') . ' KPM'
            )
                ->description('Jumlah Usulan BPJS Sedang Proses')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
        ];
    }

    protected function getFilter(): array
    {
        return [
            'dateRange' => $this->filters['daterange'] ?? null,
            'kecamatan' => $this->filters['kecamatan'] ?? null,
            'kelurahan' => $this->filters['kelurahan'] ?? null,
        ];
    }
}
