<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Models\JenisBantuan;
use App\Models\RekapPenerimaBpjs;
use App\Traits\HasWidgetShield;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget\Concerns\HasFiltersSchema;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class BantuanSosialPerBulanChart extends ApexChartWidget
{
    use HasFiltersSchema;
    use HasWidgetShield;
    use InteractsWithPageFilters;

    protected static bool $isDiscovered = true;
    protected static ?string $chartId = 'bantuanSosialPerBulanChart';
    protected static ?int $sort = 30;
    protected int|string|array $columnSpan = 'full';

    public function getHeading(): ?string
    {
        $filters = $this->filters;
        $jenisBantuan = JenisBantuan::find($filters['program'] ?? 3) ?? JenisBantuan::find(3);
        $year = $filters['tahun'] ?? now()->year;

        return 'Tren Bantuan ' . ($jenisBantuan?->alias ?? 'Program') . ' Per Bulan ' . $year;
    }

    public function filtersSchema(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('program')
                ->options(JenisBantuan::query()->pluck('alias', 'id'))
                ->default(3)
                ->native(false),
            Select::make('tahun')
                ->options(array_combine(range(now()->year, now()->year - 5), range(now()->year, now()->year - 5)))
                ->default(now()->year())
                ->native(false),
            ToggleButtons::make('cTipe')
                ->default('bar')
                ->options([
                    'line' => 'Line',
                    'bar' => 'Bar',
                ])
                ->inline()
                ->label('Tipe Chart'),
            ToggleButtons::make('cStack')
                ->default(false)
                ->options([
                    true => 'Stack',
                    false => 'Normal',
                ])
                ->inline()
                ->label('Stack'),
            Toggle::make('chartGrid')
                ->default(false)
                ->label('Tampilkan Grid'),
        ]);
    }

    public function updatedInteractsWithSchemas(string $statePath): void
    {
        $this->updateOptions();
    }

    protected function queryChart(string|int $model, int $month, array $filters): int|string|array|Builder|Collection
    {
        $model = match ((int) $model) {
            1 => BantuanPkh::class,
            2 => BantuanBpnt::class,
            3 => RekapPenerimaBpjs::class,
            4 => BantuanPpks::class,
            5 => BantuanRastra::class,
        };

        $year = $filters['tahun'] ?? now()->year;

        $query = $model::query()
            ->when($filters['kecamatan'] ?? null, fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'] ?? null, fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']));

        if (RekapPenerimaBpjs::class === $model) {
            return (int) $query->where('bulan', $month)
                ->whereYear('created_at', $year)
                ->sum('jumlah');
        }

        return $query->whereMonth('created_at', $month)
            ->where(function (Builder $query) use ($year): void {
                if (\Schema::hasColumn($query->getModel()->getTable(), 'tahun')) {
                    $query->where('tahun', $year);
                } else {
                    $query->whereYear('created_at', $year);
                }
            })
            ->count();
    }

    protected function getOptions(): array
    {
        $filters = $this->filters;
        $results = [];
        $colors = ['#3B82F6', '#F59E0B', '#10B981', '#8B5CF6', '#EF4444'];
        $gradientColors = ['#60A5FA', '#FBBF24', '#34D399', '#A78BFA', '#F87171'];

        $listBulan = list_bulan(short: true);
        $jenisBantuan = JenisBantuan::find($filters['program'] ?? 3) ?? JenisBantuan::find(3);

        foreach ($listBulan as $monthNum => $monthName) {
            $results['labels'][$monthNum] = $monthName;
            if ($jenisBantuan) {
                $results[$jenisBantuan->id][$monthName] = $this->queryChart($jenisBantuan->id, $monthNum, $filters);
            }
        }

        $cTipe = auth()->user()->instansi_id ? 'bar' : ($filters['cTipe'] ?? 'bar');
        $isStacked = (bool) ($filters['cStack'] ?? false);

        return [
            'chart' => [
                'type' => $cTipe,
                'height' => 480,
                'stacked' => $isStacked,
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
            'series' => [
                [
                    'name' => $jenisBantuan?->alias ?? 'Program',
                    'data' => $jenisBantuan ? array_values($results[$jenisBantuan->id]) : [],
                ],
            ],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 8,
                    'columnWidth' => '50%',
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
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontWeight' => 500,
                    ],
                ],
            ],
            'fill' => [
                'type' => 'gradient',
                'gradient' => [
                    'shade' => 'light',
                    'type' => 'vertical',
                    'shadeIntensity' => 0.4,
                    'gradientToColors' => $gradientColors,
                    'inverseColors' => false,
                    'opacityFrom' => 0.9,
                    'opacityTo' => 0.6,
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
            ],
            'stroke' => [
                'show' => true,
                'width' => 'line' === $cTipe ? 4 : 2,
                'curve' => 'smooth',
                'colors' => 'line' === $cTipe ? $colors : ['transparent'],
            ],
            'colors' => $colors,
            'legend' => [
                'position' => 'top',
                'horizontalAlign' => 'right',
                'fontWeight' => 600,
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
