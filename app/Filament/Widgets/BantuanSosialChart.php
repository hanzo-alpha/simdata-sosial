<?php

namespace App\Filament\Widgets;

use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class BantuanSosialChart extends ChartWidget
{
    protected static bool $isDiscovered = false;
    protected static ?string $heading = 'Bantuan Sosial';
    protected static ?string $maxHeight = '400px';
    protected static ?int $sort = 6;

    public function getDescription(): ?string
    {
        return 'The number of blog posts published per month.';
    }

//    protected function getOptions(): array
//    {
//        return [
//            'plugins' => [
//                'legend' => [
//                    'display' => false,
//                ],
//            ],
//        ];
//    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getOptions(): array|RawJs|null
    {
        return RawJs::make(<<<JS
            {
                scales: {
                    y: {
                        ticks: {
                            callback: (value) => 'Rp.' + value,
                        },
                    },
                },
            }
        JS
        );
    }
}
