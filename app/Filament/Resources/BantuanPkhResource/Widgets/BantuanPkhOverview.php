<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPkhResource\Widgets;

use App\Models\BantuanPkh;
use App\Models\Kecamatan;
use App\Traits\HasGlobalFilters;
use App\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Number;

class BantuanPkhOverview extends BaseWidget
{
    use HasGlobalFilters;
    use HasWidgetShield;
    use InteractsWithPageFilters;
    protected int|string|array $columnSpan = 'full';

    protected int|array|null $columns = 4;

    protected function getStats(): array
    {
        $filters = $this->getFilters();
        $results = [];

        $listKecamatan = Kecamatan::query()
            ->where('kabupaten_code', setting('app.kodekab'))
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('code', $filters['kecamatan']))
            ->pluck('name', 'code');

        foreach ($listKecamatan as $code => $name) {
            $value = BantuanPkh::query()
                ->select(['created_at', 'kecamatan', 'kelurahan'])
                ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
                ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
                ->where('kecamatan', $code)
                ->count();

            $results[] = $this->renderStats(
                $value,
                'KPM PKH Kec. ' . $name,
                'Total PKH Kec. ' . $name,
                'user',
            );
        }

        $results['all'] = $this->renderStats(
            BantuanPkh::query()
                ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
                ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
                ->count(),
            'Rekap KPM PKH',
            'Total KPM Program PKH',
            'users',
            'primary',
        );

        return $results;
    }

    protected function renderStats($value, $label, $desc, $icon, $color = 'success')
    {
        return Stat::make(
            label: $label ?? 'KPM PKH Kec. Marioriwawo',
            value: Number::format((float) ($value ?? 0), 0, locale: 'id') . config('custom.app.stat_prefix'),
        )
            ->description($desc ?? 'Total KPM PKH')
            ->descriptionIcon('heroicon-o-' . ($icon ?? 'user'))
            ->color($color ?? 'success');
    }
}
