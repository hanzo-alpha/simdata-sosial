<?php

declare(strict_types=1);

namespace App\Filament\Resources\PenyaluranBantuanRastraResource\Pages;

use App\Filament\Resources\PenyaluranBantuanRastraResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class ListPenyaluranBantuanRastra extends ListRecords
{
    use HasInputDateLimit;

    protected static string $resource = PenyaluranBantuanRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->disabled($this->enableInputLimitDate()),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->with(['bantuan_rastra'])->fastPaginate($this->getTableRecordsPerPage());
    }
}
