<?php

namespace App\Filament\Resources\BantuanBpntResource\Pages;

use App\Filament\Resources\BantuanBpntResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBantuanBpnts extends ManageRecords
{
    protected static string $resource = BantuanBpntResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
