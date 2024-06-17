<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanBpjsResource\Widgets;

use App\Enums\StatusUsulanEnum;
use App\Filament\Resources\BantuanBpjsResource\Pages\ListBantuanBpjs;
use App\Models\BantuanBpjs;
use App\Models\Kecamatan;
use App\Models\PesertaBpjs;
use App\Traits\HasGlobalFilters;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Number;

class BantuanBpjsOverview extends BaseWidget
{
    use HasGlobalFilters;
    use HasWidgetShield;
    use InteractsWithPageFilters;
    use InteractsWithPageTable;

    //    protected static bool $isDiscovered = false;
    protected static ?int $sort = 1;

    protected static function getQuery(array $filter): Builder
    {
        return BantuanBpjs::query()
            ->select(['created_at', 'status_bpjs', 'kecamatan', 'kelurahan'])
            ->when($filter['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filter['kecamatan']))
            ->when($filter['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filter['kelurahan']));
    }

    protected function getStats(): array
    {
        $results = [];
        $filters = $this->getFilters();

        $statistik = $this->getDataOverview($this->getFilters());
        $overview = $this->getOverview($statistik);

//        $listKecamatan = Kecamatan::query()
//            ->where('kabupaten_code', setting('app.kodekab'))
//            ->pluck('name', 'code');
//
//        foreach ($listKecamatan as $code => $name) {
//            $value = BantuanBpjs::query()
//                ->select(['created_at', 'kecamatan', 'kelurahan'])
//                ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
//                ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
//                ->where('kecamatan', $code)
//                ->count();
//            $label = 'KPM BPJS Kec. ' . $name;
//            $desc = 'Total BPJS Kec. ' . $name;
//            $icon = 'user';
//
//            $results[] = $this->renderStats($value, $label, $desc, $icon);
//        }

//        $results['all'] = $this->renderStats(
//            BantuanBpjs::count(),
//            'Rekap KPM BPJS',
//            'Total KPM Program BPJS Semua Kecamatan',
//            'users',
//            'primary',
//        );

//        $results['pbi'] = $this->renderStats(
//            PesertaBpjs::count(),
//            'Rekap Data Peserta PBI',
//            'Total KPM Peserta PBI BPJS',
//            'users',
//            'warning',
//        );
        if (count($overview) > 0) {
            return array_merge($overview, $results);
        }

        return $results;
    }

    protected function getDataOverview(array $filters): array
    {
        $verified = BantuanBpjs::query()
            ->select(['created_at', 'status_bpjs', 'kecamatan', 'kelurahan'])
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->where('status_usulan', StatusUsulanEnum::BERHASIL)
            ->count();

        $unverified = BantuanBpjs::query()
            ->select(['created_at', 'status_bpjs', 'kecamatan', 'kelurahan'])
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->where('status_usulan', StatusUsulanEnum::GAGAL)
            ->count();

        $review = BantuanBpjs::query()
            ->select(['created_at', 'status_bpjs', 'kecamatan', 'kelurahan'])
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->where('status_usulan', StatusUsulanEnum::ONPROGRESS)
            ->count();

        $jamkesda = BantuanBpjs::count();

        return [
            'jamkesda' => $jamkesda,
            'verified' => $verified,
            'unverified' => $unverified,
            'review' => $review,
        ];
    }

    protected function getTablePage(): string
    {
        return ListBantuanBpjs::class;
    }


    protected function getOverview(array $data): array
    {
        return [
            Stat::make(
                label: 'Program BPJS',
                value: Number::format($this->getPageTableQuery()->count(), 2, 0, 'id') . config('custom.app.stat_prefix'),
            )
                ->description('Total Keseluruhan Program BPJS')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
            Stat::make(
                label: 'Program BPJS Berhasil',
                value: Number::format($data['verified'], 2, 2, 'id') . config('custom.app.stat_prefix'),
            )
                ->description('Jumlah Program BPJS Berhasil')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make(
                label: 'Program BPJS Gagal',
                value: Number::format($data['unverified'], 2, 2, 'id') . config('custom.app.stat_prefix'),
            )
                ->description('Jumlah Program BPJS Gagal')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('success'),
            Stat::make(
                label: 'Program BPJS Sedang Proses',
                value: Number::format($data['review'], 2, 2, 'id') . config('custom.app.stat_prefix'),
            )
                ->description('Jumlah Program BPJS Sedang Proses')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
        ];
    }

    protected function renderStats($value, $label, $desc, $icon, $color = 'success')
    {
        return Stat::make(
            label: $label ?? 'KPM BPJS',
            value: Number::format($value ?? 0, 0, locale: ('id')) . config('custom.app.stat_prefix'),
        )
            ->description($desc ?? 'Total KPM Kec. Marioriwawo')
            ->descriptionIcon('heroicon-o-' . $icon ?? 'user')
            ->color($color ?? 'success');
    }
}
