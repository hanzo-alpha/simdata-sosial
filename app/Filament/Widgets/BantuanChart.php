<?php

namespace App\Filament\Widgets;

use App\Models\BantuanBpjs;
use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Support\RawJs;
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

    protected static ?int $contentHeight = 300;

    protected static bool $deferLoading = true;
    protected static ?int $sort = 3;
//    protected int|string|array $columnSpan = 'full';
    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];

    protected function getOptions(): array
    {
        //showing a loading indicator immediately after the page load
        if (!$this->readyToLoad) {
            return [];
        }

        //slow query
        sleep(2);

        return [
            'chart' => [
                'type' => 'pie',
                'height' => 380,
            ],
            'series' => [
                $this->renderBantuan()['rastra'],
                $this->renderBantuan()['bpjs'],
                $this->renderBantuan()['pkh'],
                $this->renderBantuan()['bpnt'],
                $this->renderBantuan()['ppks'],
                $this->renderBantuan()['angka_kemiskinan'],
            ],
            'labels' => ['RASTRA', 'BPJS', 'PKH', 'BPNT', 'PPKS', 'ANGKA KEMISKINAN'],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
                'position' => 'bottom',
            ],
        ];
    }

    protected function renderBantuan($filter = null): array
    {
        $pdd = 17.21 * 1000;
        $angka = $pdd;
        return [
            'rastra' => BantuanRastra::count(),
            'bpjs' => BantuanBpjs::count(),
            'pkh' => BantuanPkh::count(),
            'bpnt' => BantuanBpnt::count(),
            'ppks' => BantuanPpks::count(),
            'angka_kemiskinan' => $angka,
        ];
    }

    protected function extraJsOptions(): ?RawJs
    {
        return RawJs::make(
            <<<'JS'
            {
                xaxis: {
                    labels: {
                        formatter: function (val, timestamp, opts) {
                            return val + ' KPM'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (val, index) {
                            return val + ' KPM'
                        }
                    }
                },
                tooltip: {
                    x: {
                        formatter: function (val) {
                            return val + ' KPM'
                        }
                    }
                },
                plotOptions: {
                  pie: {
                    // customScale: 1,
                    offsetX: 0,
                    offsetY: 0,
                    dataLabels: {
                       offset: -25,
                       minAngleToShowLabel: -25
                    },
                    // donut: {
                    //   labels: {
                    //     show: true,
                    //   }
                    // }
                  }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opt) {
                        const name = opt.w.globals.labels[opt.seriesIndex]
                        return [name, opt.w.globals.series[opt.seriesIndex] + ' KPM']
                    },
                    dropShadow: {
                        enabled: true
                    },
                }
            }
        JS
        );
    }
}
