<?php

namespace App\Filament\Resources\BantuanPkhResource\Pages;

use App\Filament\Resources\BantuanPkhResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBantuanPkhs extends ManageRecords
{
    protected static string $resource = BantuanPkhResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
