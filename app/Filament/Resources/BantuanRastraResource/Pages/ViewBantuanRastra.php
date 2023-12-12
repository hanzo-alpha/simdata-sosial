<?php

namespace App\Filament\Resources\BantuanRastraResource\Pages;

use App\Filament\Resources\BantuanRastraResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBantuanRastra extends ViewRecord
{
    protected static string $resource = BantuanRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
