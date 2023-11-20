<?php

namespace App\Filament\Widgets;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class KeluargaChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'keluargaChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Keluarga';

    protected static ?int $contentHeight = 300; //px

    protected static bool $darkMode = false;

    protected static ?string $loadingIndicator = 'Sedang memuat...';

    protected static bool $deferLoading = true;

    protected static ?string $pollingInterval = '10s';

    protected int|string|array $columnSpan = 'full';

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
        sleep(2);

        $title = $this->filterFormData['title'];
        $dateStart = $this->filterFormData['date_start'];
        $dateEnd = $this->filterFormData['date_end'];

//        $keluarga = Keluarga::when(static function (Builder $builder) use($dateEnd, $dateStart){
//            return $builder->whereBetween($dateStart, $dateEnd);
//        })->when(function (Builder $query) use($title) {
//            return $query->where('nama_lengkap', $title);
//        })->get();


        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'BasicBarChart',
                    'data' => [7, 10, 13, 15, 18],
                ],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
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

    protected function getFormSchema(): array
    {
        return [

            TextInput::make('title')
                ->default('My Chart')
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
}
