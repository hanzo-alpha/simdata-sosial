<?php

namespace App\Filament\Resources\PenggantiRastraResource\Pages;

use App\Filament\Resources\PenggantiRastraResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePenggantiRastras extends ManageRecords
{
    protected static string $resource = PenggantiRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
