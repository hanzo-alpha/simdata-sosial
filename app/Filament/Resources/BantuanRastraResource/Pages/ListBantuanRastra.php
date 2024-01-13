<?php

namespace App\Filament\Resources\BantuanRastraResource\Pages;

use App\Exports\ExportBantuanRastra;
use App\Filament\Resources\BantuanRastraResource;
use App\Filament\Widgets\BantuanRastraOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListBantuanRastra extends ListRecords
{
    protected static string $resource = BantuanRastraResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            BantuanRastraOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->label('Ekspor XLS')
                ->color('success')
                ->exports([
                    ExportBantuanRastra::make(),
                ]),

            Actions\CreateAction::make()
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
