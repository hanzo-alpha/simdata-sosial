<?php

namespace App\Filament\Resources\DataRastraResource\Pages;

use App\Exports\ExportBantuanRastra;
use App\Filament\Resources\DataRastraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListDataRastra extends ListRecords
{
    protected static string $resource = DataRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->label('Ekspor XLS')
                ->color('success')
                ->exports([
                    ExportBantuanRastra::make()
                ]),

            Actions\CreateAction::make()
                ->icon('heroicon-o-plus'),
        ];
    }
}
