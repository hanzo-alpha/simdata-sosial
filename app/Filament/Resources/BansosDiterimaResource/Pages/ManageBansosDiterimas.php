<?php

namespace App\Filament\Resources\BansosDiterimaResource\Pages;

use App\Filament\Resources\BansosDiterimaResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBansosDiterimas extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = BansosDiterimaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->disabled($this->enableInputLimitDate()),
        ];
    }
}
