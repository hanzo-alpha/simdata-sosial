<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Models\JenisBantuan;
use App\Models\Kecamatan;
use App\Models\RekapPenerimaBpjs;
use App\Traits\HasGlobalFilters;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class BantuanSosialPerKecamatanChart extends ApexChartWidget
{
    //    use HasGlobalFilters;
    use HasWidgetShield;
    //    use InteractsWithPageFilters;

    protected static ?string $heading = 'Program Bantuan Sosial Per Kecamatan';
    protected static ?string $pollingInterval = '30s';
    protected static bool $deferLoading = true;
    protected static ?int $sort = 3;
    //    protected int|string|array $columnSpan = 'full';

    protected function getFormSchema(): array
    {
        return [
            ToggleButtons::make('chartTipe')
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

    protected function queryChart($model, $kodekec, array $filters): int|string|array|Builder|Collection
    {
        $model = match ((int) $model) {
            1 => BantuanPkh::class,
            2 => BantuanBpnt::class,
            3 => RekapPenerimaBpjs::class,
            4 => BantuanPpks::class,
            5 => BantuanRastra::class,
        };

        $query = $model::query()
            ->select(['created_at', 'kecamatan', 'kelurahan'])
            ->where('kecamatan', $kodekec);

        if (RekapPenerimaBpjs::class === $model) {
            return $query->clone()->sum('jumlah');
        }

        return $query->count();
    }

    protected function getOptions(): array
    {
        $filters = $this->filterFormData;
        $results = [];
        $colors = ['#f59e0b', '#03A9F4', '#FDD835', '#BA68C8', '#66BB6A'];
        $gradientColors = ['#fbbf24', '#79cdf2', '#ffeb9b', '#c197c9', '#96e098'];

        $kec = Kecamatan::where('kabupaten_code', setting('app.kodekab', config('custom.default.kodekab')))
            ->pluck('name', 'code');

        $jenisBantuan = JenisBantuan::pluck('alias', 'id');

        foreach ($kec as $code => $name) {
            $results['labels'][$code] = $name;

            foreach ($jenisBantuan as $id => $bantuan) {
                $results[$bantuan][$name] = $this->queryChart($id, $code, $filters);
            }
        }

        return [
            'chart' => [
                'type' => $filters['chartTipe'],
                'height' => 480,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => [
                [
                    'name' => 'BPJS',
                    'data' => array_values($results['BPJS']),
                ],
                [
                    'name' => 'PKH',
                    'data' => array_values($results['PKH']),
                ],
                [
                    'name' => 'BPNT',
                    'data' => array_values($results['BPNT']),
                ],
                [
                    'name' => 'PPKS',
                    'data' => array_values($results['PPKS']),
                ],
                [
                    'name' => 'RASTRA',
                    'data' => array_values($results['RASTRA']),
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
                'enabled' => true,
            ],
            'grid' => [
                'show' => $filters['chartGrid'],
            ],
            'tooltip' => [
                'enabled' => true,
            ],
            'stroke' => [
                'width' => 'line' === $filters['chartTipe'] ? 4 : 0,
            ],
            'colors' => $colors,
        ];
    }

    private function generateSeriesChart(string $name, array $data): array
    {
        $arr = [
            'name' => $name,
            'data' => $data,
        ];

        return [
            $arr,
        ];
    }
}
