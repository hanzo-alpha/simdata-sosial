<?php

namespace App\Filament\Widgets;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\UsulanPengaktifanTmt;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class PenerimaManfaatChart extends ApexChartWidget
{
    use HasWidgetShield;

    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'penerimaManfaatChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Penerima Manfaat Bantuan BPJS';
    protected static ?string $pollingInterval = null;
    protected static bool $deferLoading = true;
//    public ?string $filter = null;
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 3;

    protected static bool $isDiscovered = false;

//    protected function getFilters(): ?array
//    {
//        return [
//            'today' => 'Hari Ini',
//            'week' => 'Minggu Lalu',
//            'month' => 'Bulan Ini',
//            'year' => 'Tahun Ini',
//        ];
//    }

    protected function getFormSchema(): array
    {
        return [

            Select::make('kecamatan')
                ->options(Kecamatan::where('kabupaten_code', config('custom.default.kodekab'))->pluck('name', 'code'))
                ->reactive()
                ->afterStateUpdated(function (callable $set) {
                    $set('kelurahan', null);
                    $this->updateChartOptions();
                }),

            Select::make('kelurahan')
                ->options(function (callable $get) {
                    return Kelurahan::where('kecamatan_code', $get('kecamatan'))->pluck('name', 'code');
                })
                ->reactive()
                ->afterStateUpdated(function () {
                    $this->updateChartOptions();
                }),

            DatePicker::make('date_start')
                ->default('2023-01-01'),

            DatePicker::make('date_end')
                ->default('2023-12-31')

        ];
    }


    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        //showing a loading indicator immediately after the page load
        if (!$this->readyToLoad) {
            return [];
        }

        //slow query
        sleep(1);

//        $activeFilter = $this->filter;

        $title = $this->filterFormData['kecamatan'];
        $dateStart = $this->filterFormData['date_start'];
        $dateEnd = $this->filterFormData['date_end'];

        $currentDate = Carbon::now();

        $results = [];

        $kec = Kecamatan::where('kabupaten_code', config('custom.default.kodekab'))->pluck('name', 'code');
        foreach ($kec as $key => $item) {
            $results[$item] = UsulanPengaktifanTmt::where('kecamatan', 'like', $key)->get()->count();
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Total Bantuan BPJS',
                    'data' => array_values($results),
                ],
            ],
            'xaxis' => [
                'categories' => array_keys($results),
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
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => false,
                ],
            ],
        ];
    }

//    protected function getFooter(): string|View
//    {
//        return new HtmlString('<p class="text-danger-500">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>');
//    }
}
