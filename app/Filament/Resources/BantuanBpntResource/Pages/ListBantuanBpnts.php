<?php

namespace App\Filament\Resources\BantuanBpntResource\Pages;

use App\Filament\Imports\BantuanBpntImporter;
use App\Filament\Resources\BantuanBpntResource;
use App\Models\BantuanBpnt;
use App\Models\Kecamatan;
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
        $bantuan = Kecamatan::query()->where('kabupaten_code', setting('app.kodekab'))->get();
        $results = collect();
        $bantuan->each(function ($item, $key) use (&$results): void {
            $results->put('semua', Tab::make()->badge(BantuanBpnt::query()->count()));
            $results->put(Str::lower($item->name), Tab::make()
                ->badge(BantuanBpnt::query()->whereHas(
                    'kec',
                    fn(Builder $query) => $query->where('bantuan_bpnt.kecamatan', $item->code)
                )->count())
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->whereHas(
                        'kec',
                        fn(Builder $query) => $query->where('bantuan_bpnt.kecamatan', $item->code)
                    )
                ));
        });

        return $results->toArray();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make('upload')
                ->importer(BantuanBpntImporter::class)
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->label('Import CSV')
                ->closeModalByClickingAway(false)
                ->disabled(fn(): bool => cek_batas_input(setting('program.batas_tgl_input'))),
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->disabled(fn(): bool => cek_batas_input(setting('program.batas_tgl_input'))),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }

}
