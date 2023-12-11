<?php

namespace App\Filament\Resources\BantuanPkhResource\Pages;

use App\Filament\Resources\BantuanPkhResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBantuanPkh extends ViewRecord
{
    protected static string $resource = BantuanPkhResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
