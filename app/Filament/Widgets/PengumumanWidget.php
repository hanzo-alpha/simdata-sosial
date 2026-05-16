<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PengumumanWidget extends BaseWidget
{
    use HasWidgetShield;

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = -2;

    protected function getStats(): array
    {
        $announcement = setting('app.announcement', 'Selamat datang di SIMDATA SOSIAL. Pastikan data KPM Anda selalu terupdate dan tervalidasi sebelum batas waktu penyaluran.');
        $deadline = setting('app.deadline_input', 'Tanggal 25 setiap bulannya');

        return [
            Stat::make('Pengumuman Penting', $deadline)
                ->description($announcement)
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('primary'),
        ];
    }
}
