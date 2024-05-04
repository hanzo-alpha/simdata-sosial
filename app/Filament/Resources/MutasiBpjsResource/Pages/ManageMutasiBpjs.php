<?php

declare(strict_types=1);

namespace App\Filament\Resources\MutasiBpjsResource\Pages;

use App\Exports\ExportMutasiBpjs;
use App\Filament\Resources\MutasiBpjsResource;
use App\Models\MutasiBpjs;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ManageMutasiBpjs extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = MutasiBpjsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->model(MutasiBpjs::class)
                ->disabled($this->enableInputLimitDate())
                ->closeModalByClickingAway(),
            ExportAction::make()
                ->label('Ekspor XLS')
                ->color('info')
                ->disabled($this->enableInputLimitDate())
                ->exports([
                    ExportMutasiBpjs::make()
                        ->except(['created_at', 'updated_at', 'deleted_at']),
                ]),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
