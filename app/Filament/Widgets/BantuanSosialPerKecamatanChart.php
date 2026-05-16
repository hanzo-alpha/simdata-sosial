<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Models\JenisBantuan;
use App\Models\RekapPenerimaBpjs;
use App\Traits\HasGlobalFilters;
use App\Traits\HasWidgetShield;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class BantuanSosialPerKecamatanChart extends ApexChartWidget
{
    use HasGlobalFilters;
    use HasWidgetShield;
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Perbandingan Bantuan Sosial Per Kecamatan';
    protected static ?string $subheading = 'Semua program bantuan berdasarkan wilayah kecamatan';
    protected ?string $pollingInterval = '30s';
    protected static bool $deferLoading = true;
    protected static ?int $sort = 21;
    protected int|string|array $columnSpan = 'full';

    public function filtersSchema(Schema $schema): Schema
    {
        return $schema->components([
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
        ]);
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
        $filters = array_merge($this->filters, $this->getFilters());
        $results = [];
        $colors = ['#3B82F6', '#F59E0B', '#10B981', '#8B5CF6', '#EF4444'];
        $gradientColors = ['#60A5FA', '#FBBF24', '#34D399', '#A78BFA', '#F87171'];

        $kec = get_kecamatan_options();
        $jenisBantuan = JenisBantuan::pluck('alias', 'id');

        foreach ($kec as $code => $name) {
            $results['labels'][$code] = $name;
            foreach ($jenisBantuan as $id => $alias) {
                $results[$alias][$name] = $this->queryChart($id, $code, $filters);
            }
        }

        $chartTipe = $filters['chartTipe'] ?? 'bar';

        return [
            'chart' => [
                'type' => $chartTipe,
                'height' => 480,
                'toolbar' => [
                    'show' => true,
                    'tools' => [
                        'download' => true,
                        'selection' => false,
                        'zoom' => false,
                        'zoomin' => false,
                        'zoomout' => false,
                        'pan' => false,
                        'reset' => false,
                    ],
                ],
                'animations' => [
                    'enabled' => true,
                    'easing' => 'easeinout',
                    'speed' => 800,
                ],
            ],
            'series' => collect($jenisBantuan)->map(fn($alias) => [
                'name' => $alias,
                'data' => array_values($results[$alias]),
            ])->values()->toArray(),
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 8,
                    'columnWidth' => '70%',
                    'dataLabels' => [
                        'position' => 'top',
                    ],
                ],
            ],
            'xaxis' => [
                'categories' => array_values($results['labels']),
                'labels' => [
                    'style' => [
                        'fontWeight' => 600,
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
                    'shade' => 'light',
                    'type' => 'vertical',
                    'shadeIntensity' => 0.25,
                    'gradientToColors' => $gradientColors,
                    'inverseColors' => false,
                    'opacityFrom' => 0.85,
                    'opacityTo' => 0.55,
                    'stops' => [0, 100],
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'grid' => [
                'show' => (bool) ($filters['chartGrid'] ?? false),
                'borderColor' => '#f1f1f1',
                'strokeDashArray' => 4,
            ],
            'tooltip' => [
                'enabled' => true,
                'theme' => 'light',
                'shared' => true,
                'intersect' => false,
                'y' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
                'style' => [
                    'fontFamily' => 'inherit',
                ],
            ],
            'stroke' => [
                'show' => true,
                'width' => 'line' === $chartTipe ? 4 : 2,
                'curve' => 'smooth',
                'colors' => 'line' === $chartTipe ? $colors : ['transparent'],
            ],
            'colors' => $colors,
            'legend' => [
                'position' => 'top',
                'horizontalAlign' => 'center',
                'fontFamily' => 'inherit',
                'fontWeight' => 600,
                'fontSize' => '13px',
                'itemMargin' => [
                    'horizontal' => 10,
                    'vertical' => 5,
                ],
            ],
        ];
    }

    protected function extraJsOptions(): ?RawJs
    {
        return RawJs::make(<<<'JS'
            {
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            return val.toLocaleString('id-ID');
                        }
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
