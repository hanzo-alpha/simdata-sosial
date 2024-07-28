<?php

declare(strict_types=1);

namespace App\Filament\Resources\PenyaluranBantuanRastraResource\Pages;

use App\Filament\Resources\PenyaluranBantuanRastraResource;
use App\Models\BantuanRastra;
use App\Models\Kelurahan;
use App\Models\PenyaluranBantuanRastra;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ListPenyaluranBantuanRastra extends ListRecords
{
    use HasInputDateLimit;

    protected static string $resource = PenyaluranBantuanRastraResource::class;

//    public function getTabs(): array
//    {
//        if (null !== auth()->user()->instansi_id) {
//            return [];
//        }
//
//        $results = collect();
//        $bantuan = Kelurahan::query()->whereIn('kecamatan_code', config('custom.kode_kecamatan'))->get();
//        $bantuan->each(function ($item, $key) use (&$results): void {
//            $results->put('semua', Tab::make()->badge(PenyaluranBantuanRastra::query()->count()));
//            $results->put(Str::lower($item->name), Tab::make()
//                ->badge(PenyaluranBantuanRastra::query()->whereHas(
//                    'bantuan_rastra',
//                    fn(Builder $query) => $query->where('kelurahan', $item->code),
//                )->count())
//                ->modifyQueryUsing(
//                    fn(Builder $query) => $query->whereHas(
//                        'bantuan_rastra',
//                        fn(Builder $query) => $query->where('kelurahan', $item->code),
//                    ),
//                ));
//        });
//
//        return $results->toArray();
//    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->disabled($this->enableInputLimitDate()),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->with(['bantuan_rastra'])->fastPaginate($this->getTableRecordsPerPage());
    }
}
