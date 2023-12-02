<?php

namespace App\Filament\Resources\KeluargaResource\Pages;

use App\Exports\ExportKeluarga;
use App\Filament\Imports\KeluargaImporter;
use App\Filament\Resources\KeluargaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListKeluarga extends ListRecords
{
    protected static string $resource = KeluargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()->label('Ekspor XLS')
                ->exports([
                    ExportKeluarga::make()
                ]),
            Actions\ImportAction::make()
                ->label('Impor CSV')
                ->importer(KeluargaImporter::class)
                ->maxRows(10000)
                ->chunkSize(250),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
