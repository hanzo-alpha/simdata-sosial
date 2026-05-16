<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Models\JenisBantuan;
use App\Models\Kelurahan;
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

class BantuanSosialPerKelurahanChart extends ApexChartWidget
{
    use HasFiltersSchema;
    use HasWidgetShield;
    use InteractsWithPageFilters;

    protected static bool $isDiscovered = true;
    protected static ?string $chartId = 'bantuanSosialPerKelurahanChart';
    protected static bool $deferLoading = true;
    protected ?string $pollingInterval = '30s';
    protected static ?int $sort = 20;
    protected int|string|array $columnSpan = 'full';
    public function getSubheading(): ?string
    {
        return 'Data penerima bantuan berdasarkan kelurahan';
    }

    public function getHeading(): ?string
    {
        $filters = $this->filters;
        $jenisBantuan = JenisBantuan::find($filters['program'] ?? 3) ?? JenisBantuan::find(3);
        $year = $filters['tahun'] ?? 2024;

        return 'Distribusi Bantuan ' . ($jenisBantuan?->alias ?? 'Program') . ' Per Kelurahan ' . $year;
    }

    /**
     * Use this method to update the chart options when the filter form is submitted.
     */
    public function updatedInteractsWithSchemas(string $statePath): void
    {
        $this->updateOptions();
    }

    public function filtersSchema(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('program')
                ->options(JenisBantuan::query()->pluck('alias', 'id'))
                ->default(3)
                ->native(false),
            ToggleButtons::make('cTipe')
                ->default('bar')
                ->options([
                    'line' => 'Line',
                    'bar' => 'Bar',
                ])
                ->inline()
                ->grouped()
                ->label('Tipe Chart'),
            ToggleButtons::make('cStack')
                ->default(false)
                ->options([
                    true => 'Stack',
                    false => 'Normal',
                ])
                ->grouped()
                ->colors([
                    true => 'success',
                    false => 'danger',
                ])
                ->inline()
                ->label('Layout'),
            Toggle::make('chartGrid')
                ->default(false)
                ->label('Tampilkan Grid'),
            Toggle::make('cLabel')
                ->default(false)
                ->label('Tampilkan Label'),
        ]);
    }

    protected function queryChart(string|int $model, string|int|null $kodekel, array $filters): int|string|array|Builder|Collection
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
            ->where('kelurahan', $kodekel)
            ->where(function (Builder $query) use ($filters): void {
                $year = $filters['tahun'] ?? 2024;
                if (\Schema::hasColumn($query->getModel()->getTable(), 'tahun')) {
                    $query->where('tahun', $year);
                } else {
                    $query->whereYear('created_at', $year);
                }
            });
        // ->when($filters['kecamatan'] ?? null, fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
        // ->when($filters['kelurahan'] ?? null, fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']));

        if (RekapPenerimaBpjs::class === $model) {
            return $query->clone()->sum('jumlah');
        }

        return $query
            ->when($filters['program'] ?? null, fn(Builder $query) => $query->where('jenis_bantuan_id', $filters['program']))
            ->count();
    }

    protected function queryChartArray(array|\Illuminate\Support\Collection $bantuan, string|int|null $kodekel, array $filters): array
    {
        $results = [];

        foreach ($bantuan as $key => $item) {
            $model = match ((int) $item) {
                1 => BantuanPkh::class,
                2 => BantuanBpnt::class,
                3 => RekapPenerimaBpjs::class,
                4 => BantuanPpks::class,
                5 => BantuanRastra::class,
            };

            $results[] = $model::query()
                ->select(['created_at', 'kecamatan', 'kelurahan', 'jenis_bantuan_id'])
                ->when($filters['kecamatan'] ?? null, fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
                ->when($filters['kelurahan'] ?? null, fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
                ->when(
                    $filters['program'] ?? null,
                    fn(Builder $query) => $query->where('jenis_bantuan_id', $filters['program']),
                )
                ->where('kelurahan', $kodekel)
                ->count();
        }

        return $results;
    }

    protected function getOptions(): array
    {
        $filters = $this->filters;
        $results = [];
        $colors = ['#3B82F6', '#F59E0B', '#10B981', '#8B5CF6', '#EF4444'];
        $gradientColors = ['#60A5FA', '#FBBF24', '#34D399', '#A78BFA', '#F87171'];

        $kdKec = $filters['kecamatan'] ?? null;
        $kdKel = $filters['kelurahan'] ?? null;

        $userInstansiId = auth()->user()->instansi_id ?? $kdKel;

        $kel = Kelurahan::query()
            ->when($userInstansiId, function (Builder $query) use ($userInstansiId): void {
                $query->where('code', $userInstansiId);
            })
            ->when($kdKec, function (Builder $query) use ($kdKec): void {
                $query->where('kecamatan_code', $kdKec);
            })
            ->whereIn('kecamatan_code', config('custom.kode_kecamatan'))
            ->pluck('name', 'code');


        $programId = $filters['program'] ?? 3;

        $jenisBantuan = JenisBantuan::find($programId) ?? JenisBantuan::find(3);

        foreach ($kel as $code => $name) {
            $results['labels'][$code] = $name;
            if ($jenisBantuan) {
                $results[$jenisBantuan->id][$name] = $this->queryChart($jenisBantuan->id, $code, $filters);
            }
        }

        $cTipe = auth()->user()->instansi_id ? 'bar' : ($filters['cTipe'] ?? 'bar');
        $isStacked = (bool) ($filters['cStack'] ?? false);
        $chartGrid = (bool) ($filters['chartGrid'] ?? false);
        $cLabel = (bool) ($filters['cLabel'] ?? false);

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
                    'horizontal' => false,
                    'borderRadius' => 8,
                    'columnWidth' => '60%',
                    'dataLabels' => [
                        'position' => 'top',
                    ],
                ],
            ],
            'stroke' => [
                'show' => true,
                'width' => 'line' === $cTipe ? 4 : 2,
                'curve' => 'smooth',
                'colors' => 'line' === $cTipe ? $colors : ['transparent'],
            ],
            'xaxis' => [
                'categories' => array_values($results['labels']),
                'labels' => [
                    'rotate' => -45,
                    'rotateAlways' => false,
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
                'enabled' => (bool) ($cLabel ?? false),
                'offsetY' => -20,
                'style' => [
                    'fontSize' => '12px',
                    'colors' => ['#304758'],
                ],
            ],
            'grid' => [
                'show' => (bool) ($chartGrid ?? false),
                'borderColor' => '#f1f1f1',
                'padding' => [
                    'top' => 10,
                ],
            ],
            'tooltip' => [
                'enabled' => true,
                'theme' => 'light',
                'x' => [
                    'show' => true,
                ],
            ],
            'colors' => $colors,
            'legend' => [
                'position' => 'top',
                'horizontalAlign' => 'right',
                'fontFamily' => 'inherit',
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
