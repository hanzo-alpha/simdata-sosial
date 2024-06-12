<?php

declare(strict_types=1);

namespace App\Filament\Resources\MutasiBpjsResource\Pages;

use App\Enums\AlasanEnum;
use App\Enums\TipeMutasiEnum;
use App\Exports\ExportMutasiBpjs;
use App\Filament\Resources\MutasiBpjsResource;
use App\Models\BantuanBpjs;
use App\Models\MutasiBpjs;
use App\Models\PesertaBpjs;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use Wallo\FilamentSelectify\Components\ToggleButton;

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
                ->mutateFormDataUsing(function (array $data) {
                    $data['model_name'] = PesertaBpjs::class;

                    return $data;
                })
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
