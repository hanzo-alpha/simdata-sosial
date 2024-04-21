<?php

namespace App\Filament\Resources\BantuanBpntResource\Pages;

use App\Filament\Imports\BantuanBpntImporter;
use App\Filament\Resources\BantuanBpntResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class ListBantuanBpnts extends ListRecords
{
    use HasInputDateLimit;

    protected static string $resource = BantuanBpntResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make('upload')
                ->importer(BantuanBpntImporter::class)
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->label('Import CSV')
                ->closeModalByClickingAway(false),
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }

}
