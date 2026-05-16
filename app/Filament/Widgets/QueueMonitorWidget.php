<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class QueueMonitorWidget extends StatsOverviewWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';
    protected function getStats(): array
    {
        $total = \Croustibat\FilamentJobsMonitor\Models\QueueMonitor::count();
        $running = \Croustibat\FilamentJobsMonitor\Models\QueueMonitor::whereNull('finished_at')->count();
        $failed = \Croustibat\FilamentJobsMonitor\Models\QueueMonitor::where('failed', true)->count();
        $success = \Croustibat\FilamentJobsMonitor\Models\QueueMonitor::where('failed', false)->whereNotNull('finished_at')->count();

        return [
            Stat::make('Total Antrean', $total)
                ->description('Total background jobs')
                ->descriptionIcon('heroicon-m-queue-list')
                ->url(route('filament.admin.resources.queue-monitors.index'))
                ->color('info'),
            Stat::make('Sedang Berjalan', $running)
                ->description('Jobs currently processing')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('warning'),
            Stat::make('Berhasil', $success)
                ->description('Completed successfully')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Gagal', $failed)
                ->description('Jobs that failed')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
