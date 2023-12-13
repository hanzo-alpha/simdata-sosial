<?php

namespace App\Filament\Resources\DataRastraResource\Pages;

use App\Filament\Resources\DataRastraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataRastra extends EditRecord
{
    protected static string $resource = DataRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
