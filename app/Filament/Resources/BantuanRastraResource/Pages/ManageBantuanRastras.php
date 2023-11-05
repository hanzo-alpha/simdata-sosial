<?php

namespace App\Filament\Resources\BantuanRastraResource\Pages;

use App\Filament\Resources\BantuanRastraResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBantuanRastras extends ManageRecords
{
    protected static string $resource = BantuanRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
