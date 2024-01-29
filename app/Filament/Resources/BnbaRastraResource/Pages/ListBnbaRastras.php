<?php

namespace App\Filament\Resources\BnbaRastraResource\Pages;

use App\Filament\Imports\BnbaRastraImporter;
use App\Filament\Resources\BnbaRastraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBnbaRastras extends ListRecords
{
    protected static string $resource = BnbaRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->label('Impor BNBA')
                ->importer(BnbaRastraImporter::class)
                ->options(['updateExisting' => true])
                ->maxRows(10000)
                ->chunkSize(200)
                ->csvDelimiter(';')
                ->color('success')
                ->icon('heroicon-o-arrow-up-tray'),
            Actions\CreateAction::make()
                ->color('primary')
                ->icon('heroicon-o-plus'),
        ];
    }
}
