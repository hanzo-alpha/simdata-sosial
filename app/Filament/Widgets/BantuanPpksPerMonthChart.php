<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class BantuanPpksPerMonthChart extends ApexChartWidget
{
    use HasWidgetShield;

    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'bantuanPpksPerMonthChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Bantuan PPKS Per Bulan';

    protected static ?int $sort = 7;

    protected static bool $isDiscovered = false;


    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $listBulan = list_bulan(short: true);
        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Bantuan PPKS Per Bulan',
                    'data' => [7, 4, 6, 10, 14, 7, 5, 9, 10, 15, 13, 18],
                ],
            ],
            'xaxis' => [
                'categories' => array_values($listBulan),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
        ];
    }
}
