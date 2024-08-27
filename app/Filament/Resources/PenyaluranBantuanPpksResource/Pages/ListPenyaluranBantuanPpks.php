<?php

declare(strict_types=1);

namespace App\Filament\Resources\PenyaluranBantuanPpksResource\Pages;

use App\Filament\Resources\PenyaluranBantuanPpksResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class ListPenyaluranBantuanPpks extends ListRecords
{
    use HasInputDateLimit;

    protected static string $resource = PenyaluranBantuanPpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->disabled($this->enableInputLimitDate('ppks')),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->with(['bantuan_ppks'])->fastPaginate($this->getTableRecordsPerPage());
    }
}
