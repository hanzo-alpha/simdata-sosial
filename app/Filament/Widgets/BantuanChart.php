<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\JenisBantuan;
use App\Models\Kelurahan;
use App\Models\RekapPenerimaBpjs;
use App\Traits\HasWidgetShield;
use Filament\Support\RawJs;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class BantuanChart extends ApexChartWidget
{
    use HasWidgetShield;
    use InteractsWithPageFilters;

    protected static ?string $chartId = 'bantuanChart';
    protected static ?int $contentHeight = 500;
    protected static bool $deferLoading = true;
    protected ?string $pollingInterval = '30s';
    protected static ?int $sort = 11;

    protected int|string|array $columnSpan = 'full';

    public function getHeading(): ?string
    {
        return 'Distribusi Program Bantuan Sosial ' . now()->year;
    }

    protected function getOptions(): array
    {
        $bantuan = $this->renderBantuan();

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 480,
                'toolbar' => [
                    'show' => true,
                ],
                'dropShadow' => [
                    'enabled' => true,
                    'top' => 2,
                    'left' => 0,
                    'blur' => 4,
                    'opacity' => 0.1,
                ],
            ],
            'series' => $bantuan['data'],
            'labels' => $bantuan['labels'],
            'plotOptions' => [
                'pie' => [
                    'donut' => [
                        'size' => '65%',
                        'labels' => [
                            'show' => true,
                            'name' => [
                                'show' => true,
                                'fontSize' => '16px',
                                'fontWeight' => 600,
                                'fontFamily' => 'Inter',
                                'color' => '#374151',
                                'offsetY' => -10,
                            ],
                            'value' => [
                                'show' => true,
                                'fontSize' => '28px',
                                'fontWeight' => 700,
                                'fontFamily' => 'Inter',
                                'color' => '#111827',
                                'offsetY' => 10,
                            ],
                            'total' => [
                                'show' => true,
                                'label' => 'Total Penerima',
                                'fontSize' => '14px',
                                'fontWeight' => 500,
                                'fontFamily' => 'Inter',
                                'color' => '#6B7280',
                            ],
                        ],
                    ],
                    'expandOnClick' => true,
                ],
            ],
            'dataLabels' => [
                'enabled' => true,
                'dropShadow' => [
                    'enabled' => false,
                ],
                'style' => [
                    'fontSize' => '12px',
                    'fontFamily' => 'Inter',
                    'fontWeight' => 600,
                ],
            ],
            'fill' => [
                'type' => 'gradient',
                'gradient' => [
                    'shade' => 'light',
                    'type' => 'diagonal2',
                    'shadeIntensity' => 0.4,
                    'gradientToColors' => $bantuan['colors'],
                    'inverseColors' => false,
                    'opacityFrom' => 1,
                    'opacityTo' => 0.9,
                    'stops' => [0, 100],
                ],
            ],
            'stroke' => [
                'width' => 3,
                'colors' => ['#fff'],
            ],
            'legend' => [
                'position' => 'bottom',
                'horizontalAlign' => 'center',
                'fontSize' => '13px',
                'fontWeight' => 600,
                'fontFamily' => 'Inter',
                'markers' => [
                    'width' => 12,
                    'height' => 12,
                    'radius' => 12,
                ],
                'itemMargin' => [
                    'horizontal' => 15,
                    'vertical' => 8,
                ],
            ],
            'tooltip' => [
                'enabled' => true,
                'theme' => 'light',
                'style' => [
                    'fontFamily' => 'Inter',
                ],
                'y' => [
                    'title' => [
                        'formatter' => null,
                    ],
                ],
            ],
            'responsive' => [
                [
                    'breakpoint' => 768,
                    'options' => [
                        'chart' => [
                            'height' => 360,
                        ],
                        'legend' => [
                            'position' => 'bottom',
                        ],
                    ],
                ],
            ],
            'colors' => $bantuan['colors'],
        ];
    }



    protected function renderBantuan(): array
    {
        $results = [];
        $labels = [];
        $colors = [];
        $userInstansiId = auth()->user()->instansi_id;
        $kelurahan = Kelurahan::where('code', $userInstansiId)->first();
        $kdKec = $kelurahan->kecamatan_code ?? null;
        $kdKel = $kelurahan->code ?? null;
        $filters = [
            'kecamatan' => $kdKec,
            'kelurahan' => $kdKel,
        ];

        $jenisBantuan = JenisBantuan::query()->whereNot('id', 3)->get();
        foreach ($jenisBantuan as $item) {
            $labels[] = $item->alias;
            $colors[] = $item->warna;
            $model = $item->model_name;
            $query = $model::query()
                ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
                ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']));

            $results[] = (RekapPenerimaBpjs::class === $model)
                ? $query->sum('jumlah')
                : $query->count();
        }

        $angkaKemiskinan = (int) (setting('app.angka_kemiskinan') ?? 0);
        $tahunData = setting('app.tahun_data_kemiskinan', now()->year);
        $sumberData = setting('app.sumber_data_kemiskinan', 'BPS');

        $results[] = $angkaKemiskinan;
        $labels[] = "Penduduk Miskin ({$sumberData} {$tahunData})";
        $colors[] = setting('app.warna_kemiskinan', '#1aa3b2');

        return [
            'data' => $results,
            'labels' => $labels,
            'colors' => $colors,
        ];
    }

    protected function extraJsOptions(): ?RawJs
    {
        return RawJs::make(<<<'JS'
            {
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                value: {
                                    formatter: function (val) {
                                        return Number(val).toLocaleString('id-ID') + ' KPM';
                                    }
                                },
                                total: {
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce(function(a, b) {
                                            return a + b;
                                        }, 0).toLocaleString('id-ID') + ' KPM';
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    formatter: function (val, opts) {
                        return val.toFixed(1) + '%';
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return Number(val).toLocaleString('id-ID') + ' KPM';
                        }
                    }
                }
            }
        JS);
    }
}
