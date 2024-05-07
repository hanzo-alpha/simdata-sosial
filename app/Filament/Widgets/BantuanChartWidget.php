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
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Toggle;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class BantuanChartWidget extends ApexChartWidget
{
    //    use HasGlobalFilters;
    use HasWidgetShield;
    //    use InteractsWithPageFilters;

    protected static ?string $heading = 'Program Bantuan Sosial Per Kecamatan';
    protected static ?string $maxHeight = '400px';
    protected static ?string $pollingInterval = '30s';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    protected function getFormSchema(): array
    {
        return [
            Radio::make('chartTipe')
                ->default('bar')
                ->options([
                    'line' => 'Line',
                    'bar' => 'Bar',
                ])
                ->inline(true)
                ->label('Tipe'),
            Toggle::make('chartGrid')
                ->default(false)
                ->label('Tampilkan Grid'),
        ];
    }

    protected function queryChart(string $model, $kodekec, array $filters): int|string|array|Builder|Collection
    {
        return $model::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
//            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
//            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->where('kecamatan', $kodekec)
            ->count();
    }

    protected function getOptions(): array
    {
        $filters = $this->filterFormData;
        $results = [];
        $colors = ['#f59e0b', '#03A9F4', '#FDD835', '#BA68C8', '#66BB6A'];
        $gradientColors = ['#fbbf24', '#79cdf2', '#ffeb9b', '#c197c9', '#96e098'];

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

        //        dd($results);

        return [
            'chart' => [
                'type' => $filters['chartTipe'],
                'height' => 380,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => [
                [
                    'name' => 'BPJS',
                    'data' => array_values($results['bpjs']),
                ],
                [
                    'name' => 'PKH',
                    'data' => array_values($results['pkh']),
                ],
                [
                    'name' => 'BPNT',
                    'data' => array_values($results['bpnt']),
                ],
                [
                    'name' => 'PPKS',
                    'data' => array_values($results['ppks']),
                ],
                [
                    'name' => 'RASTRA',
                    'data' => array_values($results['rastra']),
                ],
            ],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 2,
                    'track' => [
                        'background' => 'transparent',
                        'strokeWidth' => '100%',
                    ],
                    'dataLabels' => [
                        'show' => true,
                        'name' => [
                            'show' => true,
                            'offsetY' => -10,
                            'fontWeight' => 600,
                            'fontFamily' => 'inherit',
                        ],
                        'value' => [
                            'show' => true,
                            'fontWeight' => 600,
                            'fontSize' => '24px',
                            'fontFamily' => 'inherit',
                        ],
                    ],
                ],
            ],
            'xaxis' => [
                'categories' => array_values($results['labels']),
                'labels' => [
                    'style' => [
                        'fontWeight' => 500,
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontWeight' => 500,
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'fill' => [
                'type' => 'gradient',
                'gradient' => [
                    'shade' => 'dark',
                    'type' => 'vertical',
                    'shadeIntensity' => 0.5,
                    'gradientToColors' => $gradientColors,
                    'inverseColors' => true,
                    'opacityFrom' => 1,
                    'opacityTo' => 1,
                    'stops' => [0, 100],
                ],
            ],

            'dataLabels' => [
                'enabled' => false,
            ],
            'grid' => [
                'show' => $filters['chartGrid'],
            ],
            //            'markers' => [
            //                'size' => $filters['chartMarkers'] ? 3 : 0,
            //            ],
            'tooltip' => [
                'enabled' => true,
            ],
            'stroke' => [
                'width' => 'line' === $filters['chartTipe'] ? 4 : 0,
            ],
            'colors' => $colors,
        ];
    }
}
