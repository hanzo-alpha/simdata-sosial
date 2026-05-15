<?php

declare(strict_types=1);

namespace App\Filament\Resources\PesertaBpjsResource\Widgets;

use App\Filament\Resources\PesertaBpjsResource\Pages\ManagePesertaBpjs;
use App\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class PesertaBpjsOverview extends BaseWidget
{
    use HasWidgetShield;
    use InteractsWithPageTable;
    protected int|string|array $columnSpan = 'full';

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
                value: Number::format((float) ($this->getPageTableQuery()->count()), locale: 'id'),
            )
                ->description('Total Seluruh KPM Peserta BPJS')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
