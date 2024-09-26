<?php

declare(strict_types=1);

namespace App\Filament\Resources\PenggantiRastraResource\Pages;

use App\Enums\StatusRastra;
use App\Filament\Resources\PenggantiRastraResource;
use App\Models\BantuanRastra;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class ManagePenggantiRastra extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = PenggantiRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->using(function (array $data, string $model) {
                    $bantuanRastraId = $data['bantuan_rastra_id'];
                    $bantuanRastra = BantuanRastra::find($bantuanRastraId);
                    $bantuanRastra->status_rastra = StatusRastra::PENGGANTI;
                    //                    $bantuanRastra->status_rastra = StatusRastra::PENGGANTI;
                    $bantuanRastra->save();

                    return $model::create($data);
                })
                ->disabled($this->enableInputLimitDate('rastra'))
                ->closeModalByClickingAway(false),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
