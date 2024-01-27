<?php

namespace App\Filament\Resources\BnbaRastraResource\Pages;

use App\Filament\Resources\BnbaRastraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBnbaRastra extends EditRecord
{
    protected static string $resource = BnbaRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
