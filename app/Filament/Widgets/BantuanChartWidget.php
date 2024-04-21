<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\BantuanBpjs;
use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Models\Kecamatan;
use App\Traits\HasGlobalFilters;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class BantuanChartWidget extends ChartWidget
{
    use HasGlobalFilters;
    use HasWidgetShield;
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Statistik Program Bantuan Per Kecamatan';

    protected static ?string $maxHeight = '400px';

    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    protected static function getQuery(string $model, array $filter): Builder
    {
        return $model::query()
            ->when($filter['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filter['kecamatan']))
            ->when($filter['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filter['kelurahan']));
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }

    protected function queryChart(string $model, $kodekec, array $filters): int|string|array|Builder|Collection
    {
        return $model::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->where('kecamatan', $kodekec)
            ->count();
    }

    protected function getData(): array
    {
        $results = [];
        $filters = $this->getFilters();

        $kec = Kecamatan::where('kabupaten_code', setting('app.kodekab', config('custom.default.kodekab')))
            ->pluck('name', 'code');

        foreach ($kec as $code => $name) {
            $results['labels'][$code] = $name;
            $results['bpjs'][$name] = $this->queryChart(BantuanBpjs::class, $code, $filters);
            $results['pkh'][$name] = $this->queryChart(BantuanPkh::class, $code, $filters);
            $results['bpnt'][$name] = $this->queryChart(BantuanBpnt::class, $code, $filters);
            $results['ppks'][$name] = $this->queryChart(BantuanPpks::class, $code, $filters);
            $results['rastra'][$name] = $this->queryChart(BantuanRastra::class, $code, $filters);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Bantuan BPJS',
                    'data' => array_values($results['bpjs']),
                    //                    'backgroundColor' => '#9BD0F5',
                    //                    'borderColor' => '#36A2EB'
                ],
                [
                    'label' => 'Bantuan PKH',
                    'data' => array_values($results['pkh']),
                    //                    'backgroundColor' => '#FF6384',
                    'borderColor' => '#FFB1C1',
                ],
                [
                    'label' => 'Bantuan BPNT',
                    'data' => array_values($results['bpnt']),
                    //                    'backgroundColor' => '#9BD0F5',
                    'borderColor' => '#36A2EB',
                ],
                [
                    'label' => 'Bantuan PPKS',
                    'data' => array_values($results['ppks']),
                    'borderColor' => '#e8c838',
                ],
                [
                    'label' => 'Bantuan RASTRA',
                    'data' => array_values($results['rastra']),
                    'borderColor' => '#20d669',
                ],
            ],
            'labels' => array_values($results['labels']),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
