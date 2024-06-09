<?php

namespace App\Filament\Widgets;

use App\Models\BantuanBpjs;
use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Models\JenisBantuan;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Str;

class BantuanChart extends ApexChartWidget
{
    use HasWidgetShield;
    use InteractsWithPageFilters;

    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'bantuanChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Statistik Program Bantuan Sosial';
    protected static ?int $contentHeight = 400;
    protected static bool $deferLoading = true;
    protected static ?int $sort = 4;

    protected function getOptions(): array
    {
        return [
            'chart' => [
                'type' => 'donut',
                'height' => 380,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => [
                $this->renderBantuan()['rastra'],
                $this->renderBantuan()['bpjs'],
                $this->renderBantuan()['pkh'],
                $this->renderBantuan()['bpnt'],
                $this->renderBantuan()['ppks'],
                $this->renderBantuan()['kemiskinan'],
            ],
            'labels' => ['RASTRA', 'BPJS', 'PKH', 'BPNT', 'PPKS', 'ANGKA KEMISKINAN'],
            'plotOptions' => [
                'radialBar' => [
                    'startAngle' => -140,
                    'endAngle' => 130,
                    'hollow' => [
                        'size' => '60%',
                        'background' => 'transparent',
                    ],
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
            'fill' => [
                'type' => 'gradient',
                'gradient' => [
                    'shade' => 'dark',
                    'type' => 'horizontal',
                    'shadeIntensity' => 0.5,
                    'gradientToColors' => ['#f59e0b'],
                    'inverseColors' => true,
                    'opacityFrom' => 1,
                    'opacityTo' => 0.9,
                    'stops' => [0, 100],
                ],
            ],
            'stroke' => [
                'dashArray' => 10,
            ],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
                //                'position' => 'bottom',
            ],
//                        'colors' => ['#2E93fA', '#66DA26', '#546E7A', '#E91E63', '#FF9800', '#5653FE', '#FF00D4']
        ];
    }

    protected function renderBantuan(): array
    {
        $results = [];

        $jenisBantuan = JenisBantuan::query()->pluck('alias', 'id');

        foreach ($jenisBantuan as $key => $item) {
            $model = match ($key) {
                1 => BantuanPkh::class,
                2 => BantuanBpnt::class,
                3 => BantuanBpjs::class,
                4 => BantuanPpks::class,
                5 => BantuanRastra::class,
            };

            $results[Str::lower($item)] = $model::query()->count();
        }

        $results['kemiskinan'] = (int) setting('app.angka_kemiskinan') ?? 0;

        return $results;
    }
}
