<?php

namespace App\Filament\Widgets;

use App\Enums\StatusVerifikasiEnum;
use App\Models\Keluarga;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Illuminate\Database\Eloquent\Builder;
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
    protected static ?string $heading = 'Penerima Manfaat Statistik';
    protected static ?string $pollingInterval = null;
    protected static bool $deferLoading = true;
    public ?string $filter = 'today';
    protected int|string|array $columnSpan = 'full';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hari Ini',
            'week' => 'Minggu Lalu',
            'month' => 'Bulan Ini',
            'year' => 'Tahun Ini',
        ];
    }

//    protected function getFormSchema(): array
//    {
//        return [
//
//            TextInput::make('title')
//                ->default('My Chart')
//                ->reactive()
//                ->afterStateUpdated(function () {
//                    $this->updateChartOptions();
//                }),
//
//            DatePicker::make('date_start')
//                ->default('2023-01-01'),
//
//            DatePicker::make('date_end')
//                ->default('2023-12-31')
//
//        ];
//    }


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

        $activeFilter = $this->filter;

//        $title = $this->filterFormData['title'];
//        $dateStart = $this->filterFormData['date_start'];
//        $dateEnd = $this->filterFormData['date_end'];

        $keluarga = Keluarga::query()
            ->when($activeFilter, function (Builder $query) use ($activeFilter) {
                $filter = match ($activeFilter) {
                    'today' => now(),
                    'week' => now()->subWeek(),
                    'month' => now()->subMonth(),
                    'year' => now()->subYear()
                };

                return $query->where('created_at', $filter);
            })
            ->where('status_verifikasi', StatusVerifikasiEnum::VERIFIED)
            ->get();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Keluarga Chart',
                    'data' => [7, 10, 13, 15, 18, 20, 24, 30, 35, 38, 40, 41],
                ],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Nov', 'Des'],
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
