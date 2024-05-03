<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPpksResource\Pages;

use App\Filament\Exports\BantuanPpksExporter;
use App\Filament\Imports\BantuanPpksImporter;
use App\Filament\Resources\BantuanPpksResource;
use App\Models\TipePpks;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Str;

final class ListBantuanPpks extends ListRecords
{
    protected static string $resource = BantuanPpksResource::class;

    public function getTabs(): array
    {
        $bantuan = TipePpks::query()->select('id', 'nama_tipe')->get();
        $results = collect();
        $bantuan->each(function ($item, $key) use (&$results): void {
            $results->put('all', Tab::make());
            $results->put(Str::lower($item->nama_tipe), Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->whereHas(
                        'tipe_ppks',
                        fn(Builder $query) => $query->where('bantuan_ppks.id', $key),
                    ),
                ));
        });

        return $results->toArray();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->label('Download CSV')
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray')
                ->exporter(BantuanPpksExporter::class),

            Actions\ImportAction::make()
                ->label('Upload CSV')
                ->color('warning')
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(BantuanPpksImporter::class)
                ->options([
                    'updateExisting' => true,
                ])
                ->closeModalByClickingAway(false),

            Actions\CreateAction::make()
                ->icon('heroicon-o-plus'),

        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }

    //    protected function getHeaderWidgets(): array
    //    {
    //        return [
    //            BantuanPpksOverview::class,
    //        ];
    //    }
}
