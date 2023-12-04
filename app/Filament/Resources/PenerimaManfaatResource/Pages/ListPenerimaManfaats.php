<?php

namespace App\Filament\Resources\PenerimaManfaatResource\Pages;

use App\Filament\Resources\PenerimaManfaatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenerimaManfaats extends ListRecords
{
    protected static string $resource = PenerimaManfaatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
