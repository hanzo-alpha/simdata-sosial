<?php

namespace App\Filament\Resources\MutasiBpjsResource\Pages;

use App\Filament\Resources\MutasiBpjsResource;
use App\Models\MutasiBpjs;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class ManageMutasiBpjs extends ManageRecords
{
    protected static string $resource = MutasiBpjsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->model(MutasiBpjs::class)
                ->closeModalByClickingAway(),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
