<?php

namespace App\Filament\Resources\HubunganKeluargaResource\Pages;

use App\Filament\Resources\HubunganKeluargaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageHubunganKeluargas extends ManageRecords
{
    protected static string $resource = HubunganKeluargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
