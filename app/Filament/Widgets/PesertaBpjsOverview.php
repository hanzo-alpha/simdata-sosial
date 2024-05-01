<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PesertaBpjsResource\Pages\ManagePesertaBpjs;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Number;

class PesertaBpjsOverview extends BaseWidget
{
    use HasWidgetShield;
    use InteractsWithPageTable;

    //    protected static bool $isDiscovered = false;
    protected static ?int $sort = 1;

    protected function getTablePage(): string
    {
        return ManagePesertaBpjs::class;
    }

    protected function getStats(): array
    {

        return [
            Stat::make(
                label: 'KPM BPJS',
                value: Number::abbreviate($this->getPageTableQuery()->count(), 2),
            )
                ->description('Total Seluruh KPM Peserta BPJS')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
