<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanRastraResource\Pages;

use App\Exports\ExportBantuanRastra;
use App\Filament\Imports\BantuanRastraImporter;
use App\Filament\Resources\BantuanRastraResource;
use App\Filament\Widgets\BantuanRastraOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListBantuanRastra extends ListRecords
{
    //    use HasToggleableTable;

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
            ExportAction::make()
                ->label('Download XLS')
                ->color('success')
                ->exports([
                    ExportBantuanRastra::make(),
                ]),

            Actions\ImportAction::make()
                ->label('Upload CSV')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('warning')
                ->importer(BantuanRastraImporter::class)
                ->options([
                    'updateExisting' => true
                ])
                ->maxRows(5000)
                ->chunkSize(100),

            Actions\CreateAction::make()
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
