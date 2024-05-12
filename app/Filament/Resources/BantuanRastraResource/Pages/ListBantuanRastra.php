<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanRastraResource\Pages;

use App\Exports\ExportBantuanRastra;
use App\Filament\Imports\BantuanRastraImporter;
use App\Filament\Resources\BantuanRastraResource;
use App\Filament\Resources\BantuanRastraResource\Widgets\BantuanRastraOverview;
use App\Models\BantuanRastra;
use App\Models\Kelurahan;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListBantuanRastra extends ListRecords
{
    use HasInputDateLimit;

    protected static string $resource = BantuanRastraResource::class;

    public function getTabs(): array
    {
        $results = collect();
        $bantuan = Kelurahan::query()->whereIn('kecamatan_code', config('custom.kode_kecamatan'))->get();
        $bantuan->each(function ($item, $key) use (&$results): void {
            $results->put('semua', Tab::make()->badge(BantuanRastra::query()->count()));
            $results->put(Str::lower($item->name), Tab::make()
                ->badge(BantuanRastra::query()->whereHas(
                    'kel',
                    fn(Builder $query) => $query->where('bantuan_rastra.kelurahan', $item->code),
                )->count())
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->whereHas(
                        'kel',
                        fn(Builder $query) => $query->where('bantuan_rastra.kelurahan', $item->code),
                    ),
                ));
        });

        return $results->toArray();
    }

    //    protected function getHeaderWidgets(): array
    //    {
    //        return [
    //            BantuanRastraOverview::class,
    //        ];
    //    }

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label('Download XLS')
                ->color('success')
                ->exports([
                    ExportBantuanRastra::make(),
                ])
                ->disabled($this->enableInputLimitDate()),

            Actions\ImportAction::make()
                ->label('Upload CSV')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('warning')
                ->importer(BantuanRastraImporter::class)
                ->options([
                    'updateExisting' => true,
                ])
                ->maxRows(5000)
                ->chunkSize(100)
                ->disabled(fn(): bool => cek_batas_input(setting('app.batas_tgl_input'))),

            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->disabled($this->enableInputLimitDate()),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
