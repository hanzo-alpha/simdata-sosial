<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\StatusVerifikasiEnum;
use App\Models\BantuanPpks;
use App\Models\Kecamatan;
use App\Traits\HasGlobalFilters;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Number;

class BantuanPpksOverview extends BaseWidget
{
    use HasGlobalFilters;
    use HasWidgetShield;
    use InteractsWithPageFilters;

    protected static bool $isDiscovered = false;
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $results = [];
        $filters = $this->getFilters();

        $statistik = $this->getDataOverview($this->getFilters());
        $overview = $this->getOverview($statistik) ?? [];

        $listKecamatan = Kecamatan::query()
            ->where('kabupaten_code', setting('app.kodekab'))
            ->pluck('name', 'code');

        foreach ($listKecamatan as $code => $name) {
            $value = BantuanPpks::query()
                ->select(['created_at', 'kecamatan', 'kelurahan'])
                ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters))
                ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters))
                ->where('kecamatan', $code)
                ->count();
            $label = 'KPM PPKS Kec. ' . $name;
            $desc = 'Total PPKS Kec. ' . $name;
            $icon = 'user';

            $results[] = $this->renderStats($value, $label, $desc, $icon);
        }

        $results['all'] = $this->renderStats(
            BantuanPpks::count(),
            'Rekap KPM PPKS',
            'Total KPM Program PPKS Semua Kecamatan',
            'users',
            'primary',
        );

        if (count($overview) > 0) {
            return array_merge($overview, $results);
        }

        return $results;
    }

    protected function getDataOverview(array $filters): array
    {
        $unverified = $this->queryBantuan($filters)
            ->where('status_verifikasi', StatusVerifikasiEnum::UNVERIFIED)
            ->count();

        $verified = $this->queryBantuan($filters)
            ->where('status_verifikasi', StatusVerifikasiEnum::VERIFIED)
            ->count();

        $review = $this->queryBantuan($filters)
            ->where('status_verifikasi', StatusVerifikasiEnum::REVIEW)
            ->count();

        return [
            'verified' => $verified,
            'unverified' => $unverified,
            'review' => $review,
        ];
    }

    protected function getOverview(array $data): array
    {
        return [
            Stat::make(
                label: 'KPM PPKS Tidak Terverifikasi',
                value: Number::format($data['unverified'], locale: 'id') . config('custom.app.stat_prefix'),
            )
                ->description('Total KPM PPKS Tidak Terverifikasi')
                ->descriptionIcon('heroicon-o-minus-circle')
                ->color('danger'),
            Stat::make(
                label: 'KPM PPKS Terverifikasi',
                value: Number::format($data['verified'], locale: 'id') . config('custom.app.stat_prefix'),
            )
                ->description('Total KPM PPKS Terverifikasi')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success'),
            Stat::make(
                label: 'KPM PPKS Ditinjau',
                value: Number::format($data['review'], locale: 'id') . config('custom.app.stat_prefix'),
            )
                ->description('Total KPM PPKS Ditinjau')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color('warning'),
        ];
    }

    protected function renderStats($value, $label, $desc, $icon, $color = 'success')
    {
        return Stat::make(
            label: $label ?? 'KPM PPKS',
            value: Number::format($value ?? 0, locale: 'id') . config('custom.app.stat_prefix'),
        )
            ->description($desc ?? 'Total KPM Kec. ')
            ->descriptionIcon('heroicon-o-' . $icon ?? 'user')
            ->color($color ?? 'success');
    }

    protected function queryBantuan(array $filters): Builder|Collection|array
    {
        return BantuanPpks::query()->with(['tipe_ppks'])
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']));
    }

    protected function filterField(): array
    {
        return [
            'tipe' => $this->filters['tipe'] ?? null,
            'kecamatan' => $this->filters['kecamatan'] ?? null,
            'kelurahan' => $this->filters['kelurahan'] ?? null,
        ];
    }
}
