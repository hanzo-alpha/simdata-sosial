<?php

namespace App\Filament\Resources\KriteriaPelayananResource\Pages;

use App\Filament\Resources\KriteriaPelayananResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKriteriaPelayanans extends ManageRecords
{
    protected static string $resource = KriteriaPelayananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
