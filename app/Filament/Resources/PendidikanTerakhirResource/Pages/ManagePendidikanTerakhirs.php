<?php

declare(strict_types=1);

namespace App\Filament\Resources\PendidikanTerakhirResource\Pages;

use App\Filament\Resources\PendidikanTerakhirResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePendidikanTerakhirs extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = PendidikanTerakhirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->disabled($this->enableInputLimitDate()),
        ];
    }
}
