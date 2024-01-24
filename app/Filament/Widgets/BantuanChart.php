<?php

namespace App\Filament\Widgets;

use App\Models\BantuanBpjs;
use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
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

    protected static ?int $contentHeight = 300;

    protected static bool $deferLoading = true;
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

//    protected function getFormSchema(): array
//    {
//        return [
//
//            Select::make('jenis_bantuan')
//                ->options(JenisBantuan::pluck('nama_bantuan', 'id'))
//                ->preload()
//                ->lazy(),
//
//            DatePicker::make('date_start')
//                ->default('2023-01-01'),
//
//            DatePicker::make('date_end')
//                ->default('2023-12-31')
//
//        ];
//    }

    protected function getOptions(): array
    {
//        $jenis = $this->filterFormData['jenis_bantuan'];
//        $dateStart = $this->filterFormData['date_start'];
//        $dateEnd = $this->filterFormData['date_end'];

        //showing a loading indicator immediately after the page load
        if ( ! $this->readyToLoad) {
            return [];
        }

        //slow query
        sleep(2);

        return [
            'chart' => [
                'type' => 'pie',
                'height' => 300,
            ],
            'series' => [
                $this->renderBantuan()['rastra'],
                $this->renderBantuan()['bpjs'],
                $this->renderBantuan()['pkh'],
                $this->renderBantuan()['bpnt'],
                $this->renderBantuan()['ppks'],
            ],
            'labels' => ['RASTRA', 'BPJS', 'PKH', 'BPNT', 'PPKS'],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }

    protected function renderBantuan($filter = null): array
    {
        return [
            'rastra' => BantuanRastra::count(),
            'bpjs' => BantuanBpjs::count(),
            'pkh' => BantuanPkh::count(),
            'bpnt' => BantuanBpnt::count(),
            'ppks' => BantuanPpks::count(),
        ];
    }

    //    protected function extraJsOptions(): ?\Filament\Support\RawJs
    //    {
    //        return RawJs::make(
    //            <<<'JS'
    //        {
    //            xaxis: {
    //                labels: {
    //                    formatter: function (val, timestamp, opts) {
    //                        return val + '/24'
    //                    }
    //                }
    //            },
    //            yaxis: {
    //                labels: {
    //                    formatter: function (val, index) {
    //                        return '$' + val
    //                    }
    //                }
    //            },
    //            tooltip: {
    //                x: {
    //                    formatter: function (val) {
    //                        return val + '/24'
    //                    }
    //                }
    //            },
    //            dataLabels: {
    //                enabled: true,
    //                formatter: function (val, opt) {
    //                    return opt.w.globals.labels[opt.dataPointIndex] + ': $' + val
    //                },
    //                dropShadow: {
    //                    enabled: true
    //                },
    //            }
    //        }
    //    JS
    //        );
    //    }
}
