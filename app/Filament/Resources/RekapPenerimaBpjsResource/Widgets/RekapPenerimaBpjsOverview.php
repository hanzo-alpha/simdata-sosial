<?php

declare(strict_types=1);

namespace App\Filament\Resources\RekapPenerimaBpjsResource\Widgets;

use App\Models\Kecamatan;
use App\Models\RekapPenerimaBpjs;
use App\Traits\HasGlobalFilters;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Number;

class RekapPenerimaBpjsOverview extends BaseWidget
{
    use HasGlobalFilters;
    use HasWidgetShield;
    use InteractsWithPageFilters;

    protected static bool $isDiscovered = false;
    protected static ?int $sort = 1;

    protected static function getQuery(array $filter): Builder
    {
        return RekapPenerimaBpjs::query()
            ->select(['created_at', 'bulan', 'jumlah', 'kecamatan', 'kelurahan'])
            ->when($filter['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filter['kecamatan']))
            ->when($filter['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filter['kelurahan']));
    }

    protected function getStats(): array
    {
        $results = [];
        $filters = $this->getFilters();

        $statistik = $this->getDataOverview($this->getFilters());
        $overview = [];

        $listKecamatan = Kecamatan::query()
            ->where('kabupaten_code', setting('app.kodekab'))
            ->pluck('name', 'code');

        foreach ($listKecamatan as $code => $name) {
            $value = RekapPenerimaBpjs::query()
                ->select(['created_at', 'jumlah', 'kecamatan', 'kelurahan'])
                ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
                ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
                ->where('kecamatan', $code)
                ->sum('jumlah');
            $label = 'KPM BPJS Kec. ' . $name;
            $desc = 'Total BPJS Kec. ' . $name;
            $icon = 'user';

            $results[] = $this->renderStats($value, $label, $desc, $icon);
        }

        $results['all'] = $this->renderStats(
            RekapPenerimaBpjs::sum('jumlah'),
            'Rekap Data Peserta PBI',
            'Total KPM Peserta PBI BPJS Semua Kecamatan',
            'users',
            'primary',
        );

        return array_merge($overview, $results);
    }

    protected function getDataOverview(array $filters): array
    {
        $verified = RekapPenerimaBpjs::query()
            ->select(['created_at', 'jumlah', 'bulan', 'kecamatan', 'kelurahan'])
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->where('bulan', now()->month)
            ->sum('jumlah');

        $unverified = RekapPenerimaBpjs::query()
            ->select(['created_at', 'jumlah', 'bulan', 'kecamatan', 'kelurahan'])
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->where('bulan', now()->subMonth(2)->month)
            ->sum('jumlah');

        $review = RekapPenerimaBpjs::query()
            ->select(['created_at', 'jumlah', 'bulan', 'kecamatan', 'kelurahan'])
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->where('bulan', now()->addMonth(1)->month)
            ->sum('jumlah');

        $jamkesda = RekapPenerimaBpjs::sum('jumlah');

        return [
            'jamkesda' => $jamkesda,
            'verified' => $verified,
            'unverified' => $unverified,
            'review' => $review,
        ];
    }

    protected function getOverview(array $data): array
    {
        return [
            Stat::make(
                label: 'Peserta PBI',
                value: Number::format($data['jamkesda'], 2, 0, 'id') . config('custom.app.stat_prefix'),
            )
                ->description('Total Peserta PBI BPJS')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
            Stat::make(
                label: 'Peserta PBI BPJS Berhasil',
                value: Number::format($data['verified'], 2, 2, 'id') . config('custom.app.stat_prefix'),
            )
                ->description('Jumlah Peserta PBI BPJS Berhasil')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make(
                label: 'Peserta PBI BPJS Gagal',
                value: Number::format($data['unverified'], 2, 2, 'id') . config('custom.app.stat_prefix'),
            )
                ->description('Jumlah Peserta PBI BPJS Gagal')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('success'),
            Stat::make(
                label: 'Peserta PBI BPJS Sedang Proses',
                value: Number::format($data['review'], 2, 2, 'id') . config('custom.app.stat_prefix'),
            )
                ->description('Jumlah Peserta PBI BPJS Sedang Proses')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
        ];
    }

    protected function renderStats($value, string $label, string $desc, string $icon, string $color = 'success')
    {
        return Stat::make(
            label: $label ?: 'KPM BPJS',
            value: Number::format((int) $value, 0, locale: ('id')) . config('custom.app.stat_prefix'),
        )
            ->description($desc ?: 'Total KPM Kec. Marioriwawo')
            ->descriptionIcon('heroicon-o-' . $icon ?? 'user')
            ->color($color ?? 'success');
    }
}
