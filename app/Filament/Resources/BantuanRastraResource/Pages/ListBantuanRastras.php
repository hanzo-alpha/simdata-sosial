<?php

namespace App\Filament\Resources\BantuanRastraResource\Pages;

use App\Exports\ExportBantuanRastra;
use App\Filament\Resources\BantuanRastraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListBantuanRastras extends ListRecords
{
    protected static string $resource = BantuanRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()->label('Ekspor XLS')
                ->color('success')
                ->exports([
                    ExportBantuanRastra::make()
                ]),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
