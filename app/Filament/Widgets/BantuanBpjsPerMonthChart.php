<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class BantuanBpjsPerMonthChart extends ApexChartWidget
{
    use HasWidgetShield;

    protected static ?string $chartId = 'bantuanBpjsPerMonthChart';

    protected static ?string $heading = 'Bantuan BPJS Per Bulan';

    protected static ?int $sort = 4;

    protected static bool $isDiscovered = false;

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
                    'name' => 'BantuanBpjsPerMonthChart',
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
