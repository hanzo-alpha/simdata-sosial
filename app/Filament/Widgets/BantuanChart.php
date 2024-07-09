<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\JenisBantuan;
use App\Models\RekapPenerimaBpjs;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

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
    protected static ?int $contentHeight = 500;
    protected static bool $deferLoading = true;
    protected static ?string $pollingInterval = '30s';
    protected static ?int $sort = 4;

    protected function getOptions(): array
    {
        return [
            'chart' => [
                'type' => 'donut',
                'height' => 480,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => $this->renderBantuan()['data'],
            'labels' => $this->renderBantuan()['labels'],
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
                    'shade' => 'light',
                    'type' => 'horizontal',
                    'shadeIntensity' => 0.5,
                    'gradientToColors' => $this->renderBantuan()['colors'],
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
            'colors' => $this->renderBantuan()['colors'],
        ];
    }

    protected function renderBantuan(): array
    {
        $results = [];
        $labels = [];
        $colors = [];

        $jenisBantuan = JenisBantuan::query()->whereNot('id', 3)->get();
        foreach ($jenisBantuan as $item) {
            $labels[] = $item->alias;
            $colors[] = $item->warna;
            $results[] = $item->model_name::query()->count();
        }

        $results[] = (int) RekapPenerimaBpjs::query()->sum('jumlah');
        $labels[] = 'BPJS';
        $colors[] = '#f0d62a';

        $results[] = (int) setting('app.angka_kemiskinan') ?? 0;
        $labels[] = 'ANGKA KEMISKINAN';
        $colors[] = setting('app.warna_kemiskinan', '#1aa3b2');

        return [
            'data' => $results,
            'labels' => $labels,
            'colors' => $colors,
        ];
    }
}
