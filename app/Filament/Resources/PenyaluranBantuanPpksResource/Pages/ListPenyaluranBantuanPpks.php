<?php

namespace App\Filament\Resources\PenyaluranBantuanPpksResource\Pages;

use App\Filament\Resources\PenyaluranBantuanPpksResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class ListPenyaluranBantuanPpks extends ListRecords
{
    protected static string $resource = PenyaluranBantuanPpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->with(['bantuan_ppks'])->fastPaginate($this->getTableRecordsPerPage());
    }
}
