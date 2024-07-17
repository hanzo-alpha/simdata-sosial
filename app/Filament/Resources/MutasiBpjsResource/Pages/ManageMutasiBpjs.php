<?php

declare(strict_types=1);

namespace App\Filament\Resources\MutasiBpjsResource\Pages;

use App\Enums\AlasanBpjsEnum;
use App\Enums\TipeMutasiEnum;
use App\Exports\ExportMutasiBpjs;
use App\Filament\Resources\MutasiBpjsResource;
use App\Models\MutasiBpjs;
use App\Models\PesertaBpjs;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ManageMutasiBpjs extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = MutasiBpjsResource::class;

    public function getTabs(): array
    {
        $results = collect();
        if (auth()->user()->hasRole(['super_admin', 'admin_bpjs', 'admin'])) {
            $bantuan = MutasiBpjs::query()->get();
            $bantuan->each(function ($item) use (&$results): void {
                $results->put(
                    'semua',
                    Tab::make()
                        ->badge(MutasiBpjs::count())
                        ->icon('heroicon-o-users'),
                );

                $results->put(Str::title(AlasanBpjsEnum::getSingleLabel($item->alasan_mutasi)), Tab::make()
                    ->icon(AlasanBpjsEnum::getSingleIcon($item->alasan_mutasi))
                    ->badge(MutasiBpjs::query()->where('alasan_mutasi', $item->alasan_mutasi)->count())
                    ->badgeColor(AlasanBpjsEnum::getSingleColor($item->alasan_mutasi))
                    ->modifyQueryUsing(
                        fn(Builder $query) => $query->where('alasan_mutasi', $item->alasan_mutasi),
                    ));
            });

            return $results->toArray();
        }

        return $results->toArray();

    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->model(MutasiBpjs::class)
                ->disabled($this->enableInputLimitDate())
                ->mutateFormDataUsing(function (array $data) {
                    $data['model_name'] = PesertaBpjs::class;
                    $data['tipe_mutasi'] ??= TipeMutasiEnum::PESERTA_BPJS;

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
