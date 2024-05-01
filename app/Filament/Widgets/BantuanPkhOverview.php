<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\BantuanPkh;
use App\Models\Kecamatan;
use App\Traits\HasGlobalFilters;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Number;

class BantuanPkhOverview extends BaseWidget
{
    use HasGlobalFilters;
    use HasWidgetShield;
    use InteractsWithPageFilters;

    protected static bool $isDiscovered = false;
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $filters = $this->getFilters();

        $results = [];

        $listKecamatan = Kecamatan::query()
            ->where('kabupaten_code', setting('app.kodekab'))
            ->pluck('name', 'code');

        foreach ($listKecamatan as $code => $name) {
            $value = BantuanPkh::query()
                ->select(['created_at', 'kecamatan', 'kelurahan'])
                ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters))
                ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters))
                ->where('kecamatan', $code)
                ->count();
            $label = 'KPM PKH Kec. '.$name;
            $desc = 'Total PKH Kec. '.$name;
            $icon = 'user';

            $results[] = $this->renderStats($value, $label, $desc, $icon);
        }

        $results['all'] = $this->renderStats(
            BantuanPkh::count(),
            'Rekap KPM PKH',
            'Total PKH All '.$filters['tipe'],
            'users',
            'primary'
        );

        return $results;
    }

    protected function renderStats($value, $label, $desc, $icon, $color = 'success')
    {
        return Stat::make(
            label: $label ?? 'KPM PKH Kec. Marioriwawo',
            value: Number::format($value ?? 0, 0, locale: 'id').config('custom.app.stat_prefix')
        )
            ->description($desc ?? 'Total KPM Kec. Marioriwawo')
            ->descriptionIcon('heroicon-o-'.$icon ?? 'arrow-trending-up')
            ->color($color ?? 'success');
    }
}
