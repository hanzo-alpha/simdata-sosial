<?php

namespace App\Filament\Resources\BeritaAcaraResource\Pages;

use App\Filament\Resources\BeritaAcaraResource;
use App\Models\BeritaAcara;
use App\Models\Kecamatan;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ManageBeritaAcaras extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = BeritaAcaraResource::class;

    public function getTabs(): array
    {
        $bantuan = Kecamatan::query()->where('kabupaten_code', setting('app.kodekab'))->get();
        $results = collect();
        $bantuan->each(function ($item, $key) use (&$results): void {
            $results->put('semua', Tab::make()->badge(BeritaAcara::query()->count()));
            $results->put(Str::lower($item->name), Tab::make()
                ->badge(BeritaAcara::query()->whereHas(
                    'kec',
                    fn(Builder $query) => $query->where('berita_acara.kecamatan', $item->code),
                )->count())
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->whereHas(
                        'kec',
                        fn(Builder $query) => $query->where('berita_acara.kecamatan', $item->code),
                    ),
                ));
        });

        return $results->toArray();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->closeModalByClickingAway(false)
                ->disabled($this->enableInputLimitDate())
        ];
    }
}
