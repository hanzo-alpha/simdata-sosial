<?php

namespace App\Filament\Resources\BantuanBpntResource\Pages;

use App\Filament\Imports\BantuanBpntImporter;
use App\Filament\Resources\BantuanBpntResource;
use App\Models\BantuanBpnt;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ListBantuanBpnts extends ListRecords
{
    use HasInputDateLimit;

    protected static string $resource = BantuanBpntResource::class;

    public function getTabs(): array
    {
        $results = collect();
        $bantuan = Kelurahan::query()->whereIn('kecamatan_code', config('custom.kode_kecamatan'))->get();
        $bantuan->each(function ($item, $key) use (&$results): void {
            $results->put('semua', Tab::make()->badge(BantuanBpnt::query()->count()));
            $results->put(Str::lower($item->name), Tab::make()
                ->badge(BantuanBpnt::query()->whereHas(
                    'kel',
                    function (Builder $query) use ($item): void {
                        $query->where('bantuan_bpnt.kelurahan', $item->code);
                    },
                )->count())
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->whereHas(
                        'kel',
                        fn(Builder $query) => $query->where('bantuan_bpnt.kelurahan', $item->code),
                    ),
                ));
        });

        return $results->toArray();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BantuanBpntResource\Widgets\BantuanBpntOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make('upload')
                ->importer(BantuanBpntImporter::class)
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->label('Upload CSV')
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

}
