<?php

declare(strict_types=1);

namespace App\Filament\Resources\HubunganKeluargaResource\Pages;

use App\Filament\Resources\HubunganKeluargaResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageHubunganKeluargas extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = HubunganKeluargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->disabled($this->enableInputLimitDate())
                ->icon('heroicon-o-plus'),
        ];
    }
}
