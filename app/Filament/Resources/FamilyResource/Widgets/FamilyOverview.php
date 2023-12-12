<?php

namespace App\Filament\Resources\FamilyResource\Widgets;

use App\Enums\StatusVerifikasiEnum;
use App\Filament\Resources\FamilyResource\Pages\ListFamilies;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FamilyOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListFamilies::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Family', $this->getPageTableQuery()->count()),
            Stat::make('Belum Diverifikasi',
                $this->getPageTableQuery()->where('status_verifikasi', StatusVerifikasiEnum::UNVERIFIED)->count()),
            Stat::make('Terverifikasi', $this->getPageTableQuery()->where('status_verifikasi',
                StatusVerifikasiEnum::VERIFIED)->count()),
        ];
    }
}
