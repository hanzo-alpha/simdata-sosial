<?php

namespace App\Filament\Resources\KriteriaPpksResource\Pages;

use App\Filament\Resources\KriteriaPpksResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKriteriaPpks extends ManageRecords
{
    protected static string $resource = KriteriaPpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
