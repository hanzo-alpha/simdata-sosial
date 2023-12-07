<?php

namespace App\Filament\Resources\BantuanPpksResource\Pages;

use App\Exports\ExportBantuanPpks;
use App\Filament\Resources\BantuanPpksResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListBantuanPpks extends ListRecords
{
    protected static string $resource = BantuanPpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->label('Ekspor XLS')
                ->color('success')
                ->exports([
                    ExportBantuanPpks::make()
                ]),

            Actions\CreateAction::make(),

        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
