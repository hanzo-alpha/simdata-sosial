<?php

namespace App\Filament\Widgets;

use App\Models\BantuanBpjs;
use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Models\JenisBantuan;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\NoReturn;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class BantuanSosialPerBulanChart extends ApexChartWidget
{
    use HasWidgetShield;

    protected static bool $isDiscovered = false;
    protected static ?string $chartId = 'bantuanSosialPerBulanChart';
    protected static ?string $heading = 'Bantuan Sosial Per Bulan Chart';
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 'full';

    protected function getFormSchema(): array
    {
        return [
            Select::make('program')
                ->options(JenisBantuan::query()->pluck('alias', 'id'))
                ->default(3)
                ->native(false),
            Select::make('bulan')
                ->options(list_bulan())
                ->native(false),
            Select::make('kecamatan')
                ->options(
                    Kecamatan::query()
                        ->where('kabupaten_code', setting('app.kodekab'))
                        ->pluck('name', 'code'),
                )
                ->live()
                ->native(false),
            Select::make('kelurahan')
                ->options(function (Get $get): \Illuminate\Support\Collection {
                    return Kelurahan::query()
                        ->where('kecamatan_code', $get('kecamatan'))
                        ->pluck('name', 'code');
                })
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
        ];
    }

    protected function queryChart(string|int $model, $kodekel, array $filters): int|string|array|Builder|Collection
    {
        $bulan = !empty($filters['bulan']) ? Carbon::parse($filters['bulan'])->month : 0;
        $kodekel = !empty($kodekel) ? Carbon::parse($kodekel) : today();
        $model = match ((int) $model) {
            1 => BantuanPkh::class,
            2 => BantuanBpnt::class,
            3 => BantuanBpjs::class,
            4 => BantuanPpks::class,
            5 => BantuanRastra::class,
        };

//        dd($bulan, $kodekel);

        return $model::query()
            ->select(['created_at', 'kecamatan', 'kelurahan', 'jenis_bantuan_id'])
            ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
            ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
            ->when($filters['program'], fn(Builder $query) => $query->where('jenis_bantuan_id', $filters['program']))
            ->when($filters['bulan'], fn(Builder $query) => $query->where('created_at', $bulan))
            ->where('created_at', $kodekel)
            ->count();
    }

    protected function queryChartArray(array|\Illuminate\Support\Collection $bantuan, $kodekel, array $filters): array
    {
        $results = [];
        $bulan = ! empty($filters['bulan']) ? Carbon::parse($filters['bulan'])->month : 0;
        foreach ($bantuan as $key => $item) {
            $model = match ((int) $item) {
                1 => BantuanPkh::class,
                2 => BantuanBpnt::class,
                3 => BantuanBpjs::class,
                4 => BantuanPpks::class,
                5 => BantuanRastra::class,
            };

            $kodekel = ! empty($kodekel) ? Carbon::parse($kodekel) : today();

            $results[$key] = $model::query()
                ->select(['created_at', 'kecamatan', 'kelurahan', 'jenis_bantuan_id'])
                ->when($filters['kecamatan'], fn(Builder $query) => $query->where('kecamatan', $filters['kecamatan']))
                ->when($filters['kelurahan'], fn(Builder $query) => $query->where('kelurahan', $filters['kelurahan']))
                ->when($filters['program'], fn(Builder $query) => $query->where('jenis_bantuan_id', $filters['program']))
                ->when($filters['bulan'], fn(Builder $query) => $query->where('created_at', $bulan))
                ->where('created_at', $kodekel)
                ->count();
        }

        return $results;
    }



    #[NoReturn] protected function getOptions(): array
    {
        $filters = $this->filterFormData;
        $results = [];
        $colors = ['#f59e0b', '#03A9F4', '#FDD835', '#BA68C8', '#66BB6A'];
        $gradientColors = ['#fbbf24', '#79cdf2', '#ffeb9b', '#c197c9', '#96e098'];

        $listBulan = list_bulan(short: true);

        $jenisBantuan = JenisBantuan::find($filters['program']) ?? JenisBantuan::pluck('id', 'alias');

        foreach ($listBulan as $code => $name) {
            $results['labels'][$code] = $name;

            $results[$jenisBantuan->id][$name] = $this->queryChart($jenisBantuan->id, $code, $filters);
        }

//        dd($results);

        $cTipe = auth()->user()->instansi_id ? 'bar' : $filters['cTipe'];
        $cTipeOpt = (bool) auth()->user()->instansi_id;

        return [
            'chart' => [
                'type' => $cTipe,
                'height' => 480,
                'toolbar' => [
                    'show' => true,
                ],
            ],
            'series' => [
                [
                    'name' => $jenisBantuan->alias,
                    'data' => array_values($results[$jenisBantuan->id]),
                ],
            ],
            'plotOptions' => [
                'bar' => [
                    'distributed' => (bool) $filters['cStack'],
                    'stacked' => (bool) $filters['cStack'],
                    'horizontal' => $cTipeOpt,
                    'borderRadius' => 2,
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
            'xaxis' => [
                'categories' => array_values($results['labels']),
                'labels' => [
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
                    'shade' => 'dark',
                    'type' => 'vertical',
                    'shadeIntensity' => 0.5,
                    'gradientToColors' => $gradientColors,
                    'inverseColors' => true,
                    'opacityFrom' => 1,
                    'opacityTo' => 1,
                    'stops' => [0, 100],
                ],
            ],

            'dataLabels' => [
                'enabled' => true,
            ],
            'grid' => [
                'show' => $filters['chartGrid'],
            ],
            'tooltip' => [
                'enabled' => true,
            ],
            'stroke' => [
                'width' => 'line' === $filters['cTipe'] ? 8 : 0,
            ],
            'colors' => $colors,
        ];
    }
}
