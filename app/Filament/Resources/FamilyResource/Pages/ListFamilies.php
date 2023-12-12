<?php

namespace App\Filament\Resources\FamilyResource\Pages;

use App\Exports\ExportKeluarga;
use App\Filament\Resources\FamilyResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListFamilies extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = FamilyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->label('Ekspor XLS')
                ->color('success')
                ->exports([
                    ExportKeluarga::make()
                ]),
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FamilyResource\Widgets\FamilyOverview::class,
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
