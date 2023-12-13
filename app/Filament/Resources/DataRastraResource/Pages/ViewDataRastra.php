<?php

namespace App\Filament\Resources\DataRastraResource\Pages;

use App\Filament\Resources\DataRastraResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDataRastra extends ViewRecord
{
    protected static string $resource = DataRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
