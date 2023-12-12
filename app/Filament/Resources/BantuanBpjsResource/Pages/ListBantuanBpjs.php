<?php

namespace App\Filament\Resources\BantuanBpjsResource\Pages;

use App\Exports\ExportBantuanBpjs;
use App\Filament\Resources\BantuanBpjsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListBantuanBpjs extends ListRecords
{
    protected static string $resource = BantuanBpjsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label('Ekspor XLS')
                ->color('success')
                ->exports([
                    ExportBantuanBpjs::make()
                ]),

            Actions\CreateAction::make(),

//            Actions\ImportAction::make()
//                ->label('Impor CSV')
//                ->importer(KeluargaImporter::class)
//                ->maxRows(10000)
//                ->chunkSize(250),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
