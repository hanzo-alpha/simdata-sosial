<?php

declare(strict_types=1);

namespace App\Filament\Resources\HubunganKeluargaResource\Pages;

use App\Filament\Resources\HubunganKeluargaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

final class ManageHubunganKeluargas extends ManageRecords
{
    protected static string $resource = HubunganKeluargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
