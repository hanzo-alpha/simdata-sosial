<?php

namespace App\Filament\Resources\KeluargaResource\Pages;

use App\Filament\Resources\KeluargaResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeluarga extends ListRecords
{
    protected static string $resource = KeluargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->slideOver()
                ->color('success'),
            Actions\CreateAction::make(),
        ];
    }
}
