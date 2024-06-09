<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPpksResource\Pages;

use App\Filament\Exports\BantuanPpksExporter;
use App\Filament\Imports\BantuanPpksImporter;
use App\Filament\Resources\BantuanPpksResource;
use App\Filament\Resources\BantuanPpksResource\Widgets\BantuanPpksOverview;
use App\Models\BantuanPpks;
use App\Models\TipePpks;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Str;

final class ListBantuanPpks extends ListRecords
{
    use HasInputDateLimit;

    protected static string $resource = BantuanPpksResource::class;

    public function getTabs(): array
    {
        $results = collect();
        if (auth()->user()->hasRole(['super_admin', 'admin_ppks', 'admin'])) {
            $bantuan = TipePpks::query()->select('id', 'nama_tipe')->get();
            $bantuan->each(function ($item) use (&$results): void {
                $results->put('semua', Tab::make()->badge(BantuanPpks::count()));
                $results->put(Str::lower($item->nama_tipe), Tab::make()
                    ->badge(BantuanPpks::query()->whereHas(
                        'tipe_ppks',
                        fn(Builder $query) => $query->where('id', $item->id),
                    )->count())
                    ->modifyQueryUsing(
                        fn(Builder $query) => $query->whereHas(
                            'tipe_ppks',
                            fn(Builder $query) => $query->where('id', $item->id),
                        ),
                    ));
            });

            return $results->toArray();
        }

        return $results->toArray();

    }

    //    protected function getHeaderWidgets(): array
    //    {
    //        return [
    //            BantuanPpksOverview::class,
    //        ];
    //    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->label('Download CSV')
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray')
                ->exporter(BantuanPpksExporter::class)
                ->disabled($this->enableInputLimitDate()),

            Actions\ImportAction::make()
                ->label('Upload CSV')
                ->color('warning')
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(BantuanPpksImporter::class)
                ->options([
                    'updateExisting' => true,
                ])
                ->closeModalByClickingAway(false)
                ->disabled($this->enableInputLimitDate()),

            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->disabled($this->enableInputLimitDate()),

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
