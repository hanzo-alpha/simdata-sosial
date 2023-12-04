<?php

namespace App\Filament\Resources\BantuanResource\Pages;

use App\Filament\Resources\BantuanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBantuan extends ViewRecord
{
    protected static string $resource = BantuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
